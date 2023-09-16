import axios from 'axios'
import configuration from '../config.json';

const instance = axios.create({
	baseURL: configuration.backend,
	timeout: 20000
})

instance.interceptors.request.use(
  function(config) {
    const authorizationToken = localStorage.getItem("authorizationToken"); 
    if (authorizationToken) {
      config.headers["authorizationToken"] = authorizationToken;
    }
    return config;
  },
  function(error) {
    return Promise.reject(error);
  }
);

instance.defaults.headers.common.Accept = 'application/json'

export default instance
