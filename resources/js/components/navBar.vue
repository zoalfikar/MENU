<template>
<div class="nav-bar">
  <div style="float:left ;">{{user? user.name : null}}</div>
  <div style="float:right ; cursor: pointer;" @click="logout()">logout</div>
</div>
</template>
<script>
import  store  from "../store/store";
export default {
    computed:{
        user:()=>store.state.user,
    },
    methods:{
        logout:()=>{ store.dispatch('logout')}
    },
    mounted() {
        store.dispatch('getUser');
  }
}
</script>
<style scoped>
.nav-bar {
    color: white;
    height:60px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin: 0;
    padding-left:20px;
    padding-right:20px;
    background-color: rgb(42, 42, 117);
}
.nav-bar div {
    height: 100%;
    display: flex;
    align-items: center;
}


</style>











