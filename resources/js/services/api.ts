import axios from "axios";
import store from "../store";

const apiClient = axios.create({
  withCredentials: true // required to handle the CSRF token
});


export default apiClient;