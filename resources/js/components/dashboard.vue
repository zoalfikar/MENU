<template>
<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3   bg-gradient-dark" id="sidenav-main">
    <div class="sidenav-header custom-header ">
     <div>{{user? user.name:''}}</div>
     <div style="float:right"><button @click="logout()">logout</button></div>
    </div>
    <hr class="horizontal light mt-0 mb-2">
    <div class="collapse navbar-collapse  w-auto  max-height-vh-200" id="sidenav-collapse-main" style="height: 80%; ">
        <ul class="navbar-nav">
            <li  v-for="(link,index) in links"
                  v-bind:key="index"
                  :class="'nav-item '">
                  <router-link :to="link.link" class="nav-link text-white "  :style="index==currentIndex?'background-color:rgba(255, 225, 225, 0.541) ;':'' " @click="()=>currentIndex=index">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">{{ link.name }}</i>
                        </div>
                  </router-link>
            </li>
        </ul>
    </div>


  </aside>
  <div :style="showMessageForm?'display:block' : 'display:none'"  class="message-from-server">
    <div><button @click="()=>showMessageForm = false">close</button></div>
     <div class="message">{{ response ? response.message:null }}</div>
  </div>
  <div :style="showErrorsForm?'display:block' : 'display:none'"  class="validation-errors">
    <div><button @click="()=>this.showErrorsForm = false">close</button></div>
        <div  v-for="(error,index) in validationErrors" v-bind:key="index">
            {{error}}
        </div>
  </div>
  <div id="content" >
    <router-view />
  </div>
</template>
<script>
import { isArray } from "@vue/shared";
import  store  from "../store/store";
export default {
    setup: () => ({
        links: [
            {
                name:'add new category' ,
                link: '/frontend-route/add-category'
            },
            {
                name:'update categories' ,
                link: '/frontend-route/update-categories'
            },
            {
                name:'add new item' ,
                link: '/frontend-route/add-item'
            },
            {
                name:'update item' ,
                link: '/frontend-route/update-items'
            },
            {
                name:'add menu discount' ,
                link: '/frontend-route/add-menu-discount'
            },
            {
                name:'add new user' ,
                link: '/frontend-route/add-user'
            },
            {
                name:'update users' ,
                link: '/frontend-route/update-users'
            },
        ]
    }),
    data:()=>{
        return{
            showMessageForm:false,
            showErrorsForm:false,
            currentIndex:null,
        }
    },
    computed:{
        user:()=>store.state.user,
        response:()=>store.state.responsFromServer,
        validationErrors:()=>store.state.validationErorrs
    },
    watch:{
        response: {
            deep: true,
            handler (value, oldValue) {
                this.showMessageForm = true;
            }
        },
        validationErrors: {
            deep: true,
                handler (value, oldValue) {
                    this.showErrorsForm = true;
                }
            }
    },
    methods:{
        logout:()=>store.dispatch('logout')
    },
    mounted() {
        store.dispatch('getUsers');
        store.dispatch('getMenu');
        store.dispatch('getUser');
  }
}
</script>
<style scoped>
    @import "../../css/dashbord.css" ;
    #content{
       background-color: rgba(255, 225, 225, 0.541); width: 65%; height: 87%;
       margin-left:25% ;
       margin-top :3%;
       margin-right :10%;
       margin-bottom :10%;
       padding: 10px;
    }
    .custom-header{
        padding: 15px;
        padding-top: 20px;
        color:white;

    }
    .custom-header button{
        padding: 10px;
       float: right;
       color: aliceblue;
       border-radius:30% ;
       border-style:none ;
       background-color: rgb(54, 54, 54);

    }
    .custom-header div{
        height: 100%;
        display: flex;
        align-items: center;
       float: left;
    }
    .message-from-server ,.validation-errors{
        position: absolute;
        width: 30%;
        left: 40%;
        background-color: white;
        padding: 20px;
        z-index: 100;
    }
    .validation-errors{
        background-color: red;
        color: white;

    }
    .message-from-server button ,.validation-errors button{
        background-color: black;
        color: white;
        border-style: none;
        width: 100%;
    }
    .message{
        padding-top: 20px;
        color: black;
        font-size: large;
    }
    .validation-errors{
        top: 30%;
    }
</style>











