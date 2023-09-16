import axios from './axios'
import { getTime } from 'date-fns';

export default function Auth() {
	return new Promise( async (resolve, reject) => {
		const token = getTime(new Date())
		if(!token)
			resolve(false)
		const request = await axios.get(`/authenticate2/${token}`)
		if(request.data.success)
			resolve(true)
		resolve(false)
	})
}
