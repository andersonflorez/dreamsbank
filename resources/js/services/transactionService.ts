import apiClient from "./api";
import { showErrorsRequest, showSuccessRequest } from "../utils";

export default {
    async getAllData(options: any) {
        return await apiClient
            .post("/getAllTransactions", options)
            .then((response: any) => {
                return response.data;
            })
            .catch((error: any) => {
                showErrorsRequest(error.response.data);
                return null;
            });
    },
    async getProductsApproved() {
        return await apiClient
            .get("/getProductsApproved")
            .then((response: any) => {
                return response.data;
            })
            .catch((error: any) => {
                showErrorsRequest(error.response.data);
                return null;
            });
    }
};
