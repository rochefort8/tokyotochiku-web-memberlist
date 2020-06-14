<template>
    <div>
        <div class="form-group">
            <router-link :to="{name: 'createMember'}" class="btn btn-success"><i class ="glyphicon glyphicon-plus"></i>新規登録</router-link>
        </div>
        <div class="input-group">
            <div class="input-group-btn search-panel">
                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span id="search_concept">お名前</span> 
                </button>

                <ul class="dropdown-menu" role="menu">
                    <li><a href="javascript:void(0)" @click="updateOption('name','お名前')">お名前</a></li>                   
                    <li><a href="javascript:void(0)" @click="updateOption('graduate','卒業期')">卒業期</a></li>
                    <li><a href="javascript:void(0)" @click="updateOption('email','メールアドレス')">メールアドレス</a></li>
                    <li><a href="javascript:void(0)" @click="updateOption('address','住所')">住所</a></li>
                    <li><a href="javascript:void(0)" @click="updateOption('phone','電話番号')">電話番号</a></li>
                    <li><a href="javascript:void(0)" @click="updateOption('club','部活動')">部活動</a></li>
                    <li><a href="javascript:void(0)" @click="updateOption('junior_high_school','出身中学')">出身中学</a></li>
                </ul>
            </div>
            <input type="hidden" name="search_param" value="all" id="search_param">         
            <input type="text" class="form-control" id="search_keyword" v-model="keyword" placeholder="Type content...">
            <span class="input-group-btn">
                <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-search"></span></button>
            </span>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">MembersS list</div>
            <div class="panel-body">
                <div class="row">
	                <div class="col-sm-6">
                        <ul class="pagination">
                            <li :class="{disabled: current_page <= 1}"><a href="#" @click="change(1)">&laquo;</a></li>
                            <li :class="{disabled: current_page <= 1}"><a href="#" @click="change(current_page - 1)">&lt;</a></li>
                            <li v-for="page in pages" :key="page" :class="{active: page === current_page}">
                                <a href="#" @click="change(page)">{{page}}</a>
                            </li>
                            <li :class="{disabled: current_page >= last_page}"><a href="#" @click="change(current_page + 1)">&gt;</a></li>
                            <li :class="{disabled: current_page >= last_page}"><a href="#" @click="change(last_page)">&raquo;</a></li>
                        </ul>
                    </div>
                    <div style="margin-top: 40px" class="col-sm-6 text-right">全 {{total}} 件中 {{from}} 〜 {{to}} 件表示</div>
                </div>
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>卒業期</th>
                            <th>お名前</th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th>性別</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="member, index in members">
                            <td>{{ member.graduate }}</td>
                            <td>{{ member.last_name_kanji }}</td>
                            <td>{{ member.first_name_kanji }}</td>
                            <td>{{ member.last_name_kana }}</td>
                            <td>{{ member.first_name_kana }}</td>
                            <td>{{ member.gender }}</td>
                            <td>
                                <router-link :to="{name: 'viewMember', params: {id: member.id}}" class="btn btn-xs btn-default"><i class="glyphicon glyphicon-eye-open"></i></router-link>
                                <router-link :to="{name: 'editMember', params: {id: member.id}}" class="btn btn-xs btn-default"><i class="glyphicon glyphicon-pencil"></i>
                                </router-link>
                                <a href="#"
                                class="btn btn-xs btn-danger"
                                v-on:click="deleteEntry(member.id, index)"><i class="glyphicon glyphicon-trash"></i>
                                </a>
                            </td>
                        </tr>    
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data: function () {
            return {
                members: [],
                current_page: 1,
                last_page: 1,
                total: 1,
                from: 0,
                to: 0,
                keyword: '',
                search_item: 'name'
            }
        },
        props: {
            options: {
                type: [Array, Object]
            },
            selected: {},
            placeholder: [String]
        },
        mounted() {
    	    this.load(1);

            this.selectedOption = this.selected;
            if (this.placeholder)
            {
                this.placeholderText = this.placeholder;
            }
        },
        watch: {
            keyword: function (q) {
                var app = this;
                axios.get('/api/member?' + this.search_item + '=' + q)
                    .then(function (resp) {

                        app.members = resp.data;
                        app.current_page = resp.data.current_page;
                        app.last_page = resp.data.last_page;
                        app.total = resp.data.total;
                        app.from = resp.data.from;
                        app.to = resp.data.to;
                    })
                    .catch(function (resp) {
                        console.log(resp);
                        alert("Could not load members");
                    });	   
            }
        },
        methods: {
            load(page) {	
                var app = this;
                var url = '/api/member?page=' + page ;

                if (this.keyword != "") {
                    url = url + '&' + this.search_item + '=' + this.keyword;
                }
                
                axios.get(url)
                .then(function (resp) {
//                    app.members = resp.data.data;
                    app.members = resp.data;
                    app.current_page = resp.data.current_page;
                    app.last_page = resp.data.last_page;
                    app.total = resp.data.total;
                    app.from = resp.data.from;
                    app.to = resp.data.to;
                })
                .catch(function (resp) {
                    console.log(resp);
                    alert("Could not load members");
                });
    	    },
            change(page) {
                if (page >= 1 && page <= this.last_page) this.load(page)
            },
            deleteEntry(id, index) {
                if (confirm("Do you really want to delete it?")) {
                    var app = this;
                    axios.delete('/api/member/' + id)
                        .then(function (resp) {
                            app.members.splice(index, 1);
                        })
                        .catch(function (resp) {
                            alert("Could not delete member");
                        });
                }
            },
            updateOption(option,text) {
                this.search_item = option;
                $('.search-panel span#search_concept').text(text);
                this.keyword = '';
                this.load(1);
            },
            toggleMenu() {
              this.showMenu = !this.showMenu;
            }
        },
        computed: {
            pages() {
                let start = _.max([this.current_page - 2, 1])
                let end = _.min([start + 5, this.last_page + 1])
                start = _.max([end - 5, 1])
                return _.range(start, end)
            },
        }
    }
</script>
