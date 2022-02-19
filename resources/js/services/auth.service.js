import axios from 'axios';

const API_URL = 'http://localhost:8000/';

class AuthService {
    async login(credentials) {
        await axios.get('/sanctum/csrf-cookie');
        let response = await axios.post('login', credentials);
        if (response.data) {
            let token = response.config.headers['X-XSRF-TOKEN']
            localStorage.setItem('x_xsrf_token', token)
            return {
                token: token,
                user: response.data
            }
        }
        return response;
    }

    logout() {
        axios.post('logout').then(response => {
            localStorage.removeItem('x_xsrf_token')

            return response.data;
        });
    }

    register(user) {
        return axios.post( 'register', {
            username: user.username,
            email: user.email,
            password: user.password
        });
    }
}

export default new AuthService();
