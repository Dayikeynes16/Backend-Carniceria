import axios from "axios";

const axiosInstance =
    axios.create();
    
const token = document
    .querySelector("meta[name='csrf-token']")
    .getAttribute("content");

axiosInstance.interceptors.request.use(
    (config) => {
        config.headers = {
            ...config.headers,
            Accept: "application/json",
            headers: { "X-CSRF-TOKEN": token },
        };

        console.log("axios new");

        return config;
    },
    (error) => {
        console.log(error.response);

        return Promise.reject(error);
    }
);

export default axiosInstance;
