declare module "*.vue" {
    import Vue from "vue";
    export default Vue;
}

interface ITransaction{
    id: Number,
    product: string,
    commerce: string,
    amount: string,
    state: string,
    created_at?: Date
}

interface IProduct{
    id?: Number,
    name: string,
    number?: string,
    state?: string,
    created_at?: Date
}