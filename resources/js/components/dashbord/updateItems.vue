<template>
    <h3>update Items</h3>
    <h4 v-if="currentParentCategory">
            <span>Main Menu</span>
            <span  v-for="(p) in parentCategory" v-bind:key="p.id">
                / {{ p.title }}
            </span>
        </h4>
        <h4 v-else>Main Menu</h4>
    <div v-if="showCaNotItems">
        <button @click="goBack()">back</button>
        <div v-if="currentSubMenu">
            <div class="cats">
                <div  v-for="(ca) in currentSubMenu" v-bind:key="ca.id">
                    <p>{{ca.title}}</p>
                    <p>{{ca.type == 'parentCa' ? 'parent category' : 'items category'}}</p>
                    <button :style="ca.type !== 'parentCa' ? 'display:none':'' " @click="selectCa(ca)">show</button>
                    <button :style="ca.type == 'parentCa' ? 'display:none':'' " @click="showItems(ca)">items</button>
                </div>
            </div>
        </div>
    </div>
    <div v-else>
        <button @click="goBackToCa()">back</button>
        <div class="items">
            <div  v-for="it  in currentItems" v-bind:key="it.id">
                <p>{{it.title}}</p>
                <p>price &nbsp; {{it.price}}</p>
                <p>discount &nbsp;{{it.discountPercent}}% </p>
                <button  @click="()=>{currentItem=it;showForm=true }">update</button>
                <button  @click="deleteItem(it.id)">delete</button>
            </div>
        </div>
    </div>
    <div :style="showForm?'':'display:none'" :class="'category-form'">
            <label for="title">title</label>
            <input v-model="updatedItem.title" type="text">


            <label for="price">price</label>
            <input v-model="updatedItem.price" type="number" placeholder="format 0.00">

            <label for="discountPercent">discount</label>
            <input v-model="updatedItem.discountPercent" type="number" >


            <button @click="save()">save</button>
            <button @click="showForm=false">close</button>
    </div>
</template>

<script>
import store from '../../store/store';

export default {
    data:()=>{
        return {
            menuDeep:[],
            parentCategory:[],
            currentItems:[],
            currentItem:null,
            updatedItem:{
                    title:null,
                    price:null,
                    discountPercent:null,
                    categoryId :null
                },
                showForm:false,
                showCaNotItems:true
        }
    },
    computed:{
        menu:()=>store.state.menu,
        currentSubMenu:function () {
            return this.menuDeep[this.menuDeep.length -1]
        },
        currentParentCategory:function () {
            return this.parentCategory[this.parentCategory.length -1]
        },
    },
    watch:{
        currentItem:function (n , o) {
            this.updatedItem.id=n.id
            this.updatedItem.title=n.title
            this.updatedItem.price=n.price
            this.updatedItem.discountPercent=n.discountPercent
            this.updatedItem.categoryId=n.categoryId
        },
        menu:function (newMenu , oldMenu) {
            this.historyPoint();
        }
    },
    methods:{
        selectCa:function (category){
            if (category.type === 'parentCa')
            {
                this.menuDeep.push(category.sub_categories)
                this.parentCategory.push(category)
            }
        },
        showItems:function (category){
            this.parentCategory.push(category)
            if (category.type === 'itemsCa')
            {
                this.showCaNotItems=false
                this.currentItems = category.items
            }
        },
        goBack:function (){
            if (this.menuDeep.length > 1)
            this.menuDeep.pop()
            this.parentCategory.pop()
        },
        goBackToCa:function (){
            this.showCaNotItems=true
            this.currentItems =[]
            this.parentCategory.pop()
        },
        save:function(){
                store.dispatch('updateItem' ,{ id:this.updatedItem.id,item:this.updatedItem})
            },
        deleteItem:function(id){
            store.dispatch('deleteItem' ,id)
        },
         historyPoint(){
            // no need to refresh browser
            var history=[];
            this.currentItems=[];
            for (let index = 0; index < this.menuDeep.length; index++) {
                this.menuDeep.pop();
            }
            this.menuDeep.push(this.menu)
            for (let index = 0; index < this.parentCategory.length; index++) {
                this.menuDeep[this.menuDeep.length -1].map((m)=>{
                    if (m.id === this.parentCategory[index].id)
                   {
                    if(this.parentCategory[index].type === 'parentCa')
                    this.menuDeep.push(m.sub_categories)
                    history.push(m)
                    }
                })
            }
            for (let index = 0; index < history.length; index++) {
                this.parentCategory.pop()
            }
            for (let index = 0; index < history.length; index++) {
                this.parentCategory.push(history[index])
            }
            if (this.parentCategory.length > 1) {
                this.currentItems = this.parentCategory[this.parentCategory.length -1].items
            }
         }
    },
    mounted:function(){
        this.$data.menuDeep.push(this.menu);
    }
}
</script>

<style scoped>
    .category-form {
        padding: 30px;
        position: absolute;
        width: 50%;
        top: 10%;
        left: 25%;
        display: grid;
        grid-template-columns: 50% 50%;
        background-color: aliceblue;
        grid-row-gap: 40px;
    }
    .category-form label{
        margin-right:10px ;
    }
    h3{
        text-align: center;
    }
    .cats{
        width:100%;
        margin-top: 30px;
        padding: 30px;
        display: grid;
        grid-template-columns: 25% 25% 25% 25%;
        grid-row-gap: 10px;
        grid-column-gap: 10px;

    }
    .cats{
        cursor: pointer;
        background-color: rgb(18, 18, 48);
        color: white;
    }
    .items{
        width:100%;
        margin-top: 30px;
        padding: 30px;
        display: grid;
        grid-template-columns: 25% 25% 25% 25%;
        grid-row-gap: 10px;
        grid-column-gap: 10px;
        cursor: pointer;
        background-color: rgb(75, 70, 50);
        color: white;
    }
    .add:hover{
        background-color: rgba(59, 59, 77, 0.637);
    }
</style>

