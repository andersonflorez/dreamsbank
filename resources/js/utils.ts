import Vue from "vue";

export const showErrorsRequest = (errors: any) => {
    console.log(errors)

    if(errors.errors){
        errors = Object.values(errors.errors);
    
        errors.forEach((element: any) => {
            Vue.notify({
                group: "alert",
                type: "error",
                title: "Error",
                text: element[0]
            });
        });
    }else{
        Vue.notify({
            group: "alert",
            type: "error",
            title: "Error",
            text: errors.error
        });
    }
};

export const showSuccessRequest = (data: any) => {
    Vue.notify({
        group: "alert",
        type: "success",
        title: "Bien!!!",
        text: data.message
    });
};
