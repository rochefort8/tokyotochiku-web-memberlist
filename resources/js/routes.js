export default [
    { path: '/dashboard', component: require('./components/Dashboard.vue').default },
    { path: '/profile', component: require('./components/Profile.vue').default },
    { path: '/developer', component: require('./components/Developer.vue').default },
    { path: '/users', component: require('./components/Users.vue').default },
    { path: '/products', component: require('./components/product/Products.vue').default },
    
    { path: '/members', component: require('./components/members/Members.vue').default },
    { path: '/members/edit', component: require('./components/members/MembersEdit.vue').default },
    { path: '/members/create', component: require('./components/members/MembersCreate.vue').default },
    { path: '/members/view', component: require('./components/members/MembersView.vue').default },
    { path: '/members/delete', component: require('./components/members/MembersDelete.vue').default },
    { path: '/members/removed', component: require('./components/members/RemovedList.vue').default },

    { path: '/annualfee', component: require('./components/annualfee/AnnualFee.vue').default },
    { path: '/annualfee/add', component: require('./components/annualfee/AddMember.vue').default },
    { path: '/annualfee/count', component: require('./components/annualfee/CountPerGraduate.vue').default },

    { path: '/newsletter', component: require('./components/newsletter/DeliveryList.vue').default },
    { path: '/newsletter/undelivered', component: require('./components/newsletter/UndeliveredList.vue').default },

    { path: '/product/tag', component: require('./components/product/Tag.vue').default },
    { path: '/product/category', component: require('./components/product/Category.vue').default },
    { path: '*', component: require('./components/NotFound.vue').default }
];
