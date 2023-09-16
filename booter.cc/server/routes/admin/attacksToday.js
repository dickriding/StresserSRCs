const checkAdmin = require('../../functions/checkAdmin')

const logsSchema = require('../../models/logs')
const yup = require('yup');

const schema = yup.object().shape({
	Token: yup.string().length(64).required()
});

module.exports = app => {
	app.get('/admin/attacksToday/:id', async (req, res, next) => {
		const {
			authorizationtoken: Token
		} = req.headers
		try {
			await schema.validate({
				Token
			})
			
			const userFound = await checkAdmin(Token, req.useragent)
			if(!userFound.admin) 
				return next(new Error('User is not an admin.'))

			const attacksToday = logsSchema.aggregate([ 
			  {
			    $group: {
			      _id: { $month: "$createdAt" }, // group by the month *number*, mongodb doesn't have a way to format date as month names
			      numberofdocuments: { $sum: 1 }
			    }
			  },
			  {
			    $project: {
			      _id: false, // remove _id
			      month: { // set the field month as the month name representing the month number
			        $arrayElemAt: [
			          [
			            "", // month number starts at 1, so the 0th element can be anything
			            "january",
			            "february",
			            "march",
			            "april",
			            "may",
			            "june",
			            "july",
			            "august",
			            "september",
			            "october",
			            "november",
			            "december"
			          ],
			          "$_id"
			        ]
			      },
			      numberofdocuments: true // keep the count
			    }
			  }
			])
		 	return res.send({
		 		success : true,
		 		message : attacksToday
		 	})
		} catch (err)
		{
			return next(err)
		}
	})
}