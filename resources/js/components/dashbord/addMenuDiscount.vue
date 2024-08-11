<template>
    <h3>Add discount for all menu</h3>

    <div class="dis">
        <div class="input">
        <label for="discount">discount</label>
        <input v-model="discount" type="number" name="discount" id="discount">
        <label for="discount">%</label>
        </div>
        <button @click="save()">save</button>
    </div>


  </template>

  <script>
import store from '../../store/store';


  export default {
    data:()=>{
            return {
                discount: null
            }
        },
          methods:{
            save:function(){
                store.dispatch('setMenuDiscount' ,{discountPercent:this.discount})
            }
        }
  }
  </script>

  <style>
  .dis{
    margin-top: 40px;
    display: block;
  }
  .input  input{
    margin-right: 5px;
    margin-left: 5px;
  }
    h3{
        text-align: center;
    }
  </style>
