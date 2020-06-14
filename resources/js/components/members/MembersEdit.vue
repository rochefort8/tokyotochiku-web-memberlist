<template>
    <div>
        <div class="form-group">
            <router-link to="/" class="btn btn-default">Back</router-link>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
		        <p>{{ member.graduate }}期</p>
	            <h1>{{ member.last_name_kanji }} {{ member.first_name_kanji }}</h1>
		        <p class="lead">{{ member.last_name_kana }} {{ member.first_name_kana }}</p>
	        </div>
            <div class="panel-body">
                <form v-on:submit="saveForm()">
            	    <table class="table">
                        <tbody>
                            <tr>
                                <th>お名前(漢字)</th>
                                <td>{{ member.last_name_kanji }} {{ member.first_name_kanji }}</td>
                                <td>
                                </td>
                            </tr>
                            <tr>
                                <th>お名前(カナ)</th>
                                <td>{{ member.last_name_kana }} {{ member.first_name_kana }}</td>
                                <td>
                                </td>
                            </tr>
                            <tr>
                                <th>卒業期</th>
                                <td>{{ member.graduate }}期</td>
                                <td>
                                </td>
                            </tr>
                            <tr>
                                <th>住所</th>
                                <td>{{ member.postcode }}<br>{{ member.address }}</td>
                                <td>
                                </td>
                            </tr>
                            <tr>
                                <th>メールアドレス</th>
                                <td>
                                    <div v-if="show">{{ member.email }}</div>
                                    <div v-else><input type="text" v-model="member.email" class="form-control"></div>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-xs btn-default" @click="show = !show"><i class="glyphicon glyphicon-pencil"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <th>電話番号1</th>
                                <td>{{ member.phone1 }}</td>
                                <td>
                                    <button type="button" class="btn btn-xs btn-default"  @click="show = !show"><i class="glyphicon glyphicon-pencil"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <th>電話番号2</th>
                                <td>{{ member.phone2 }}</td>
                                <td>
                                </td>
                            </tr>
                            <tr>
                                <th>出身中学</th>
                                <td>{{ member.junior_high_school }}</td>
                                <td>
                                </td>
                            </tr>
                            <tr>
                                <th>部活動</th>
                                <td>{{ member.club }}</td>
                                <td>
                                </td>
                            </tr>
                            <tr>
                                <th>夫婦</th>
                                <td>{{ member.couple }}</td>
                                <td>
                                </td>
                            </tr>
                            <tr>
                                <th>ID</th>
                                <td>{{ member.id }}</td>
                                <td>
                                </td>
                            </tr>

                            <tr>
                                <th>期別幹事</th>
                                <td>{{ member.representative }}</td>
                                <td>
                                </td>
                            </tr>
                            <tr>
                                <th>備考</th>
                                <td>{{ member.remarks }}</td>
                                <td>
                                </td>
                            </tr>
                        </tbody>
        		    </table>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            let app = this;
            let id = app.$route.params.id;
            app.memberId = id;
            axios.get('/api/v1/members/' + id)
                .then(function (resp) {
                    app.member = resp.data;
                })
                .catch(function () {
                    alert("Could not load your member")
                });
        },
        data: function () {
            return {
                show: 'false',
                memberId: null,
                member: {
                    name: '',
                    address: '',
                    website: '',
                    email: '',
                }
            }
        },
        methods: {
            saveForm() {
                var app = this;
                var newMember = app.member;
                axios.patch('/api/v1/members/' + app.memberId, newMember)
                    .then(function (resp) {
                        app.$router.replace('/');
                    })
                    .catch(function (resp) {
                        console.log(resp);
                        alert("Could not create your member");
                    });
            }
        }
    }
</script>
