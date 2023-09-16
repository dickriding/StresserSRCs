const rateLimit = require("express-rate-limit");
const axios = require('axios');

const userSchema = require('../../models/user')

const trimLower = require('../../functions/trimLower')
const generateString = require('../../functions/generateString')

const yup = require('yup')

const schema = yup.object().shape({
	email : yup.string().min(4).max(64).email().required(),
	username: yup.string().min(4).max(16).required(),
	password: yup.string().min(8).max(32).required(),
	recaptcha: yup.string().required('reCaptcha value is required.')
})

const captchaSecretKey = '6Lc0ulgbAAAAAESGB_IzVSLbM61pnuGBt-sE32Ko'
module.exports = (app) => {
	app.post('/register', async (req, res, next) => {
		let {
			email,
			username,
			password,
			recaptcha
		} = req.body
		try {
			await schema.validate({
				email,
				username,
				password,
				recaptcha
			})

			const response = await axios.post(`https://www.google.com/recaptcha/api/siteverify?secret=${captchaSecretKey}&response=${recaptcha}`)
			if(response.data.success === false)
				return next(new Error('Request failed due to an internal error'))

			email = trimLower(email)
			username = trimLower(username)

			const isEmail = await userSchema.findOne({ email : email })
			if(isEmail)
				return next(new Error('Email already exists, please pick a new one'))
			
			const isUsername = await userSchema.findOne({ username : username })
			if(isUsername)
				return next(new Error('Username already exists, please pick a new one'))

			if(email === null || email === undefined)
				return next(new Error('Pick a valid email'))

			if(username === null || username === undefined)
				return next(new Error('Pick a valid username'))

			if(password === null || password === undefined)
				return next(new Error('Pick a valid password'))

			const userAccount = new userSchema()
			
			userAccount.email = email
			userAccount.username = username
			userAccount.password = userAccount.generateHash(password)
			userAccount.api_key = generateString(18)
			
			await userAccount.save()
			
			return res.send({
				success : true,
				message : 'User has been created successfuly'
			})
		} catch (err) {
			return next(err)
		}
	})
}