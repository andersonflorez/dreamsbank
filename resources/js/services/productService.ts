import apiClient from "./api";
import { showErrorsRequest, showSuccessRequest } from "../utils";

export default {
    async create(product: IProduct) {
        return await apiClient
            .post("/products", product)
            .then((response: any) => {
                showSuccessRequest(response.data);
            })
            .catch((error: any) => {
                showErrorsRequest(error.response.data);
            });
    },
    async delete(id: Number) {
        return await apiClient
            .delete(`/products/${id}`)
            .then((response: any) => {
                showSuccessRequest(response.data);
            })
            .catch((error: any) => {
                showErrorsRequest(error.response.data);
            });
    },
    async update(product: IProduct, id: Number) {
        return await apiClient
            .put(`/products/${id}`, product)
            .then((response: any) => {
                showSuccessRequest(response.data);
            })
            .catch((error: any) => {
                showErrorsRequest(error.response.data);
            });
    },
    async getAllData(options: any) {
        return await apiClient
            .post("/getAllProducts", options)
            .then((response: any) => {
                return response.data;
            })
            .catch((error: any) => {
                showErrorsRequest(error.response.data);
                return null;
            });
    }
};
