<template>
    <h3> Update users</h3>
    <table>
        <tr>
            <th>name</th>
            <th>identifier</th>
            <th>role</th>
            <th>action</th>
        </tr>
        <tr  v-for="(user) in users" v-bind:key="user.id">
            <td>{{user.identifier}}</td>
            <td>{{user.name}}</td>
            <td>{{user.role}}</td>
            <td><button @click="remove(user.id)">delete</button></td>
        </tr>

</table>

  </template>

  <script>
import store from '../../store/store'
  export default {
    computed:{
        users:()=>store.state.users,
    },
    methods:{
        remove:function (id) {
            store.dispatch('deleteUser',id)
        }
    }
  }
  </script>

  <style>
    table{
        margin-top: 40px;
        width: 100%;
    }
    table td , table th{
       padding: 10px;
    }
    h3{
        text-align: center;
    }
  </style>
