module.exports = (program, args, data) => {
   let payload = program
   args.forEach( (e) => {
      switch (e.type) {
         case 'host':
            payload = payload + ' ' + data.host
            break;
         case 'port':
            payload = payload + ' ' + (data.port ? data.port: 80)
            break;
         case 'time':
            payload = payload + ' ' + (data.time ? data.time : 60)
            break;
         case 'postdata':
            payload = payload + ' ' + (data.postdata ? data.postdata : 'null')
            break;
         case 'headers':
            payload = payload + ' ' + (data.headers ? data.headers : 'nil')
            break;
         case 'proxy':
            payload = payload + ' ' + (data.proxyUsed ? data.proxyUsed : 0)
            break;
         case 'rest':
            payload = payload + ' ' + (data.rest ? data.rest : 'get')
            break;
         case 'cookie':
            payload = payload + ' ' + (data.cookie ? data.cookie : 'cookie=cookie')
               break;
         case 'getquery':
            payload = payload + ' ' + (data.getquery ? data.getquery : 'user=test')
            break;
         default:
            payload = payload + ' ' + e.arg 
      }
   })
   payload.trim()
   return payload
}