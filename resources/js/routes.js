export default [
    { path: '/dashboard', component: require('./components/Dashboard.vue').default },
    { path: '/profile', component: require('./components/Profile.vue').default },
    { path: '/developer', component: require('./components/Developer.vue').default },
    { path: '/users', component: require('./components/Users.vue').default },
    { path: '/products', component: require('./components/product/Products.vue').default },
    { path: '/members', component: require('./components/members/Members.vue').default },
    { path: '/members/index', component: require('./components/members/MembersIndex.vue').default },
    { path: '/members/edit', component: require('./components/members/MembersEdit.vue').default },
    { path: '/members/create', component: require('./components/members/MembersCreate.vue').default },
    { path: '/members/view', component: require('./components/members/MembersCreate.vue').default },
    { path: '/product/tag', component: require('./components/product/Tag.vue').default },
    { path: '/product/category', component: require('./components/product/Category.vue').default },
    { path: '*', component: require('./components/NotFound.vue').default }
];
