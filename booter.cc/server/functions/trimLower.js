module.exports = (string) => {
	if(!string)
		throw new Error('You did not provide a param to trimLower')
	string = string.trim()
	string = string.toLowerCase()
	return string
}