<template>
    <div class="menu">
        <div class="lev level1">
            <div v-for="ca in menu" v-bind:key="ca.id" class="ca" @click="()=>level1Ca=ca" :style="level1Ca && level1Ca.id == ca.id?'background-color: rgba(212, 35, 35);': '' ">
                <span>{{ca.title}}</span><span> -{{ca.currentDiscountPercent}}%</span>
            </div>
        </div>
        <div class="lev level2">
            <div v-for="ca in level2" v-bind:key="ca.id" class="ca" @click="level2Ca=ca" :style="level2Ca && level2Ca.id == ca.id?'background-color: rgba(212, 35, 35);': '' ">
                <span>{{ca.title}}</span><span> -{{ca.currentDiscountPercent}}%</span>
            </div>
        </div>
        <div class="lev level3">
            <div v-for="ca in level3" v-bind:key="ca.id" class="ca" @click="level3Ca=ca" :style="level3Ca && level3Ca.id == ca.id?'background-color: rgba(212, 35, 35);': '' ">
                <span>{{ca.title}}</span><span> -{{ca.currentDiscountPercent}}%</span>
            </div>
        </div>
        <div class="lev level4">
            <div v-for="ca in level4" v-bind:key="ca.id" class="ca" @click="level4Ca=ca" :style="level4Ca && level4Ca.id == ca.id?'background-color: rgba(212, 35, 35);': '' ">
                <span>{{ca.title}}</span><span> -{{ca.currentDiscountPercent}}%</span>
            </div>
        </div>
        <div class="items">
            <div class="item-card" v-for="it in items" v-bind:key="it.id">
                <div class="item">
                    <div>{{it.title}}</div><div>price {{it.price}}$</div>
                    <div>{{it.currentDiscountPercent}}% discount</div><div>netprice {{it.netPrice}}$</div>
                </div>
                <div class="add"><button>+</button></div>
            </div>

        </div>
    </div>
</template>
<script>
import store from '../store/store';

export default {
    data:()=>{
        return{
            level1Ca:null,
            level2Ca:null,
            level3Ca:null,
            level4Ca:null,
            level2:[],
            level3:[],
            level4:[],
            items:[],
        }
    },
    computed:{
        menu:()=>store.state.menu,
        level2:function () {
            return this.level1Ca ? this.level1Ca.sub_categories:[]
        },
        level3:function () {
            return this.level2Ca ? this.level2Ca.sub_categories:[]
        },
        level4:function () {
            return this.level3Ca ? this.level3Ca.sub_categories:[]
        },
    },
    watch:{
        level1Ca:function (newCa , old) {

            this.level2Ca=null
            this.level3Ca=null
            this.level4Ca=null

            if(newCa)
            if (newCa.type === 'parentCa') {
                this.items = []
            }
            else{
                this.items = newCa.items
            }
        },
        level2Ca:function (newCa , old) {
            this.level3Ca=null
            this.level4Ca=null
            if(newCa)
            if (newCa.type === 'parentCa') {
                this.items = []
            }
            else{
                this.items = newCa.items
            }
        } ,
        level3Ca:function (newCa , old) {
            this.level4Ca=null
            if(newCa)
            if (newCa.type === 'parentCa') {
                this.items = []
            }
            else{
                this.items = newCa.items
            }
        },
        level4Ca:function (newCa , old) {
            if(newCa)
            if (newCa.type === 'parentCa') {
                this.items = []
            }
            else{
                this.items = newCa.items
            }
        }

    },
    mounted() {
        store.dispatch('getRestaurantMenu');
    }
}
</script>
<style scoped>
    .menu{
        background-color: rgba(230, 213, 213, 0.836);
        min-height: 12cm;
        max-height: 15cm;
        overflow-y: scroll;
        padding-top:30px ;
        padding-bottom:30px ;
        display: grid;
        grid-template-areas: '.level1' '.level2' '.level3' '.level4' '.items';
        grid-template-columns: 17% 17% 17% 17% 32%;
    }

    .lev{
        padding-left: 5px;
        padding-right: 5px;
        display: flex;
        flex-direction: column;
        gap: 40px;
        overflow: auto;
    }
    .ca{
        border-radius: 10px;
        min-height: 50px;
        background-color: black;
        color: white;
        padding: 10px;
        width: 100%;
        display: flex;
        justify-content: space-between;
        align-items: center;
        cursor: pointer;

    }
    .ca:hover{
        transform: translateY(-1px);
        background-color: rgb(119, 72, 72);
    }

    .items{
        padding-left: 5px;
        padding-right: 5px;
        display: flex;
        flex-direction: column;
        gap: 40px;
        overflow: auto;

    }
    .item-card{
        padding: 10px;
        width: 100%;
        background-color: rgb(249, 247, 255);
    }
    .item{
        width: 100%;
        display: grid;
        grid-template-columns: 50% 50%;
    }
    .add button{
        width:  100%;
    }
    .add button:hover{
        background-color: bisque;
    }
</style>
