import { createWebHistory, createRouter } from "vue-router";
import addCategory from "../components/dashbord/addCategory";
import addItem from "../components/dashbord/addItem";
import addUser from "../components/dashbord/addUser";
import updateCategories from "../components/dashbord/updateCategories";
import updateItems from "../components/dashbord/updateItems";
import updateUsers from "../components/dashbord/updateUsers";
import addMenuDiscount from "../components/dashbord/addMenuDiscount";

const routes = [{
        path: "/frontend-route/add-category",
        name: 'addCategory',
        component: addCategory,
    }, {
        path: "/frontend-route/add-item",
        name: 'addItem',
        component: addItem,
    }, {
        path: "/frontend-route/add-user",
        name: 'addUser',
        component: addUser,
    }, {
        path: "/frontend-route/update-categories",
        name: 'updateCategories',
        component: updateCategories,
    }, {
        path: "/frontend-route/update-items",
        name: 'updateItems',
        component: updateItems,
    }, {
        path: "/frontend-route/update-users",
        name: 'updateUsers',
        component: updateUsers,
    },
    {
        path: "/frontend-route/add-menu-discount",
        name: 'addMenuDiscount',
        component: addMenuDiscount,
    },

];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
