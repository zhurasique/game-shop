<template>
    <div>
        <div class="alert alert-success text-center" id="alert-success" role="alert">
            <p v-text="alert"></p>
        </div>
        <div class="alert alert-danger text-center" id="alert-danger" role="alert">
            <p v-text="alert"></p>
        </div>
    </div>
</template>

<script>
export default {
    props: ['alert'],

    methods: {
        showDangerAlert: function (){
            let alert = document.getElementById("alert-danger");
            alert.style.display = "unset";

            setTimeout(function (){
                alert.style.display = "none";
            },2000);
        },

        showSuccessAlert: function (){
            let alert = document.getElementById("alert-success");
            alert.style.display = "unset";

            setTimeout(function (){
                alert.style.display = "none";
            },2000);
        }
    }
}
</script>
