<template>
        <h3>add user</h3>
        <div class="category-form">

            <div>
                <label for="name">name</label>
                <input v-model="user.name" type="text" name="name" id="name">
            </div>

            <div>
                <label for="identifier">identifier</label>
                <input v-model="user.identifier" type="number" name="identifier" id="identifier">
            </div>

            <div>
                <label for="role">role</label>
                <select id="role" v-model="user.role" name="role">
                    <option value="admin">admin</option>
                    <option value="user">user</option>
                </select>
            </div>

            <div>
                <label for="password">password</label>
                <input v-model="user.password" type="password" name="password" id="password">
            </div>

            <button @click="save()">save</button>
        </div>

  </template>

  <script>
import store from '../../store/store'
  export default {
        data:()=>{
            return {
                user:{
                    name:null,
                    identifier:null,
                    role:null,
                    password:null
                }
            }
        },
          methods:{
            save:function(){
                store.dispatch('createUser' ,this.user)
            }
        }
    }
  </script>

  <style>

  .category-form {
        margin-top: 40px;
        padding: 30px;
        width: 100%;
        display: grid;
        grid-template-columns: 50% 50%;
        grid-row-gap: 40px;
    }
    .category-form label{
        margin-right:10px ;
    }
    h3{
        text-align: center;
    }
  </style>
