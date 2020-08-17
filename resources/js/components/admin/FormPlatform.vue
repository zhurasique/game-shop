<template>
    <div :class="{'loading': loading}">
        <div class="text-center">
            <h2>Platforms</h2>
        </div>

        <div class="alert alert-success text-center" id="alert-success" role="alert">
            <p v-text="alert_text"></p>
        </div>
        <div class="alert alert-danger text-center" id="alert-danger" role="alert">
            <p v-text="alert_text"></p>
        </div>

        <form>
            <div class="form-group">
                <label for="name"><strong>Name:</strong></label>
                <input type="text" id="name" name="name" class="form-control" placeholder="Xbox" required v-model="name">
            </div>
        </form>

        <div class="col-sm mt-3" id="subBtn">
            <button class="btn btn-block btn-success" @click="savePlatform">SUBMIT PLATFORM</button>
        </div>

        <table class="table mt-4">
            <thead>
            <tr>
                <th scope="col" class="borderless">ID</th>
                <th scope="col" class="borderless">Name</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="platform in platforms" :key="platform.id">
                <th v-text="platform.id"></th>
                <td v-text="platform.name"></td>
                <td class="text-center">
<!--                    <button class="btn btn-sm btn-primary" @click="editPlatform(platform)">Edit</button>-->
                    <button class="btn btn-sm btn-danger" @click="deletePlatform(platform)">Delete</button>
                </td>
            </tr>
            </tbody>
        </table>

        <div class="row justify-content-center" id="pageBtn">
            <div class="col-sm-6 text-center">
                <div class="btn-group" role="group" aria-label="Basic example">
                    <button type="button" class="btn btn-secondary" v-if="current_page !== 1" @click="decCurrentPage">Previous</button>
                    <button class="btn btn-outline-secondary" v-text="current_page"></button>
                    <button type="button" class="btn btn-secondary" v-if="current_page !== last_page" @click="incCurrentPage">Next</button>
                </div>
            </div>
        </div>
        <hr>
    </div>
</template>
<script>

import axios from "axios"
import apiJson from "../../config/config.json"

export default {
    data: function(){
        return {
            platform_api: apiJson[0]['platform_api'],
            id: '',
            name: '',
            platforms: [],
            current_page: 1,
            last_page: '',
            loading: true,
            alert_text: ''
        }
    },

    mounted(){
        this.loadPlatforms();
    },

    methods: {
        loadPlatforms: function (){
            this.platforms = [];
            axios({
                method: "get",
                url: this.platform_api + "/paginate?page=" + this.current_page
            })
                .then( response => {
                    for(var i = 0; i < response.data['data'].length; i++){
                        this.platforms.push(response.data['data'][i]);
                    }

                    this.current_page = response.data['meta']['current_page'];
                    this.last_page = response.data['meta']['last_page'];
                    this.pageLoading();
                }).
            catch( error => {
                console.log(error);
            });
        },

        savePlatform: function (){
            let formData = new FormData();
            formData.append("name", this.name);

            axios({
                url: this.platform_api,
                data: formData,
                method: 'POST',
            }).then( response => {
                this.name = '';

                this.loadPlatforms();
                this.showSuccessAlert("Platform has been saved!");
            });
        },

        deletePlatform: function (platform){
            axios({
                method: "delete",
                url: this.platform_api + "/" + platform.id
            })
                .then( response => {
                    this.loadPlatforms();
                    this.showDangerAlert("Platform has been deleted!");
                }).
            catch( error => {
                console.log(error);
            });
        },

        incCurrentPage: function (){
            this.current_page++;
            this.loadPlatforms();
        },

        decCurrentPage: function (){
            this.current_page--;
            this.loadPlatforms();
        },

        pageLoading: function (){
            this.loading = false;
            document.getElementById("subBtn").style.display = "unset";
            document.getElementById("pageBtn").style.display = "flex";
        },

        showDangerAlert: function (text){
            let alert = document.getElementById("alert-danger");
            alert.style.display = "unset";
            this.alert_text = text;

            setTimeout(function (){
                alert.style.display = "none";
            },2000);
        },

        showSuccessAlert: function (text){
            let alert = document.getElementById("alert-success");
            alert.style.display = "unset";
            this.alert_text = text;

            setTimeout(function (){
                alert.style.display = "none";
            },2000);
        },
    }
}
</script>
