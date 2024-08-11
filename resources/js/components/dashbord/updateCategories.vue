<template>
    <h3>Update categories</h3>
    <div>
        <h4 v-if="currentParentCategory">
            <span>Main Menu</span>
            <span  v-for="(p) in parentCategory" v-bind:key="p.id">
                / {{ p.title }}
            </span>
        </h4>
        <h4 v-else>Main Menu</h4>
        <button @click="goBack()">back</button>
        <div v-if="currentSubMenu">
            <div class="cats">
                <div  v-for="(ca) in currentSubMenu" v-bind:key="ca.id">
                    <p>{{ca.title}}</p>
                    <p>{{ca.discountPercent?`${ca.discountPercent} %`: 'no'}}&nbsp; discount </p>
                    <button :style="ca.type !== 'parentCa' ? 'display:none':'' " @click="selectCa(ca)">show</button>
                    <button  @click="()=>{currentCa=ca;showForm=true }">update</button>
                    <button  @click="deleteCa(ca.id)">delete</button>
                </div>
            </div>
        </div>
    </div>
    <div :style="showForm?'':'display:none'" :class="'category-form'">
        <div>
            <label for="title">title</label>
            <input v-model="updatedCa.title" type="text">
        </div>

        <div>
            <label for="discountPercent">discount</label>
            <input v-model="updatedCa.discountPercent" type="number" >
            <label for="discountPercent">%</label>
        </div>

        <div style="display:flex ; justify-content: space-between;">
            <button @click="save()">save</button>
            <button @click="showForm=false">close</button>
        </div>

    </div>
</template>

<script>
import store from '../../store/store';

export default {
    data:()=>{
        return {
            menuDeep:[],
            parentCategory:[],
            updatedCa:{
                    title:null,
                    type:null,
                    discountPercent:null,
                    parentId:null
                },
                showForm:false,
                currentCa:null
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
        currentCa:function (n , o) {
            this.updatedCa.id=n.id
            this.updatedCa.type=n.type
            this.updatedCa.title=n.title
            this.updatedCa.discountPercent=n.discountPercent
            this.updatedCa.parentId=n.parentId
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
        goBack:function (){
            if (this.menuDeep.length > 1)
            this.menuDeep.pop()
            this.parentCategory.pop()
        },
        save:function(){
                store.dispatch('updateCategory' ,{id:this.updatedCa.id, category:this.updatedCa})
            },
        deleteCa:function(id){
            store.dispatch('deleteCategory' ,id)
        },
         historyPoint(){
            // no need to refresh browser
            var history=[];
            for (let index = 0; index < this.menuDeep.length; index++) {
                this.menuDeep.pop();
            }
            this.menuDeep.push(this.menu)
            for (let index = 0; index < this.parentCategory.length; index++) {
                this.menuDeep[this.menuDeep.length -1].map((m)=>{
                    if (m.id == this.parentCategory[index].id)
                    this.menuDeep.push(m.sub_categories)
                })
                history.push(this.parentCategory[index])
            }
            for (let index = 0; index < history.length; index++) {
                this.parentCategory.pop()
            }
            for (let index = 0; index < history.length; index++) {
                this.parentCategory.push(history[index])
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
</style>
