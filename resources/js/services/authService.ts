import apiClient from "./api";
import { showErrorsRequest } from "../utils";

export default {
    async login(credentials: any) {
        await apiClient.get("/sanctum/csrf-cookie");
        await apiClient.post("/login", credentials).catch((error: any) => {
            showErrorsRequest(error.response.data);
        });
    },
    logout() {
        return apiClient.post("/logout");
    },
    authUser() {
        return apiClient.get("/getUser");
    }
};
