<template>
    <h3>Add new category</h3>
    <div>
        <h4 v-if="currentParentCategory">
            <span>Main Menu</span>
            <span  v-for="(p) in parentCategory" v-bind:key="p.id">
                / {{ p.title }}
            </span>
        </h4>
        <h4 v-else>Main Menu</h4>
        <button @click="goBack()">back</button>
        <div class="cats">
            <div class="ca add" @click="()=>showForm=true">add new category here +</div>
            <div class="ca" v-for="(ca) in currentSubMenu" v-bind:key="ca.id">
                <p>{{ca.title}}</p>
                <p>{{ca.type == 'parentCa' ? 'parent category' : 'items category'}}</p>
                <button :style="ca.type !== 'parentCa' ? 'display:none':'' " @click="selectCa(ca)">show</button>
            </div>
        </div>
    </div>
    <div :style="showForm?'':'display:none'" :class="'category-form'">
        <div>
            <label for="title">title</label>
            <input v-model="newCa.title" type="text">
        </div>

        <div>
            <label for="discountPercent">discount</label>
            <input v-model="newCa.discountPercent" type="number" >
        </div>

        <div>
            <label for="type">type</label>
            <select id="type" v-model="newCa.type" >
                <option value="parentCa">parent category</option>
                <option value="itemsCa">items category</option>
            </select>
        </div>

        <div style="display:flex ; justify-content: space-around;">
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
            newCa:{
                    title:null,
                    type:null,
                    discountPercent:null,
                    parentId:null
                },
                showForm:false
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
        currentParentCategory:function (newV, oldV) {
            if (newV)
                this.newCa.parentId = newV.id
            else
                this.newCa.parentId = null
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
                store.dispatch('createCategory' ,this.newCa)
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
                    if (m.id === this.parentCategory[index].id)
                   {
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
    .add:hover{
        background-color: rgba(59, 59, 77, 0.637);
    }
</style>
