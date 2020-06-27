<template>
  <section class="content">
    <div class="container-fluid">
        <div class="row">

          <div class="col-12">
        
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">新規登録</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">

                <form @submit.prevent="saveForm()">
                    <div class="modal-body">

                        <div class="col-xs-12 form-group">
                            <label class="control-label">お名前（漢字）</label>    
                            <div class="form-row align-items-center">
                              <div class="col-sm-6">

                                <div class="input-group">
                                  <div class="input-group-prepend">
                                    <div class="input-group-text">姓</div>
                                  </div>
                                  <input type="text" class="form-control" name="last_name_kanji" id="name_kanji_family" placeholder="" x-autocompletetype="surname" required>
                                </div>
                              </div>

                              <div class="col-sm-6">
                                <div class="input-group">
                                  <div class="input-group-prepend">
                                    <div class="input-group-text">名</div>
                                  </div>
                                  <input type="text" class="form-control" name="first_name_kanji" id="name_kanji_family" placeholder="" x-autocompletetype="surname" required>
                                </div>
                              </div>
                          </div>
                        </div>  

                        <div class="col-xs-12 form-group">
                            <label class="control-label">お名前（カナ）</label>    
                            <div class="form-row align-items-center">
                              <div class="col-sm-6">

                                <div class="input-group">
                                  <div class="input-group-prepend">
                                    <div class="input-group-text">セイ</div>
                                  </div>
                                  <input type="text" class="form-control" name="last_name_kana" id="name_kanji_family" placeholder="" x-autocompletetype="surname" required>
                                </div>
                              </div>

                              <div class="col-sm-6">
                                <div class="input-group">
                                  <div class="input-group-prepend">
                                    <div class="input-group-text">メイ</div>
                                  </div>
                                   <input type="text" class="form-control" name="first_name_kana" id="name_kanji_family" placeholder="" x-autocompletetype="surname" required>
                                </div>
                              </div>
                          </div>
                        </div>  

                        <!-- 卒業期 -->
                        <div class="form-group col-xs-12 has-feedback">
                            <label for="graduate" class="control-label">卒業期</label>
                            <select v-model="graduate" class="form-control" x-autocompletetype="region">
                                <option value="" selected="selected">-- 卒業期 --</option>
                                <option v-for="graduate in graduates" v-bind:value="graduate.value">
                                    {{ graduate.value }}期({{ graduate.string }})
                                </option>
                            </select>
                        </div>

                        <!--　メールアドレス -->
                        <div class="col-xs-12 form-group">
                            <label for="email" class="control-label">メールアドレス</label>
                            <input type="email" class="form-control alphabet" name="email" id="email" placeholder="yoki-kana@tochiku.com" pattern="^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$" x-autocompletetype="email" required>
                        </div>

                        <!-- 住所 -->
                        <div class="form-group col-xs-12 has-feedback">
                            <label for="zip" class="control-label">郵便番号</label>
                            <input type="text" class="form-control alphabet" name="zip" v-model="zip" placeholder="xxx-xxxx" pattern="\d{3}[\-\s]?\d{4}" x-autocompletetype="postal-code">
                          
                            <span class="help-block">入力後に住所が自動入力されます</span>
                        </div>
                        <div class="form-group col-xs-12 has-feedback">
                            <label for="pref" class="control-label">都道府県</label>
                            <select v-model="pref" class="form-control" x-autocompletetype="region">
                                <option value="" selected="selected">-- 都道府県 --</option>
                                <optgroup v-for="region,i in regions":label="region">
                                    <option v-for="pref in prefs[i++]">
                                        {{ pref }}
                                    </option>
                                </optgroup>
                            </select>
                        </div>
                        <div class="form-group col-xs-12 has-feedback">
                            <label for="address" class="control-label">市区町村/番地</label>
                            <input type="text" class="form-control" v-model="address" x-autocompletetype="street-address">
                        </div>
                        <div class="form-group col-xs-12 has-feedback"> 
                           <label for="building" class="control-label">建物名など</label>
                            <input type="text" class="form-control" name="building" id="building">
                        </div>
                        <div class="form-group col-xs-12 has-feedback">
  
                            <label for="tel" class="control-label">電話番号</label>
                            <input type="tel" class="form-control alphabet" name="tel" id="tel" placeholder="" pattern="(0\d{1,4}[\-\s]?\d{1,4}[\-\s]\d{4})||(0{1}\d{9,10})" x-autocompletetype="phone-national">
                            <span class="help-block"><span class="label label-default">注</span>市外局番よりご記入ください。</span>
                            <span class="help-block">固定電話/携帯電話いずれもOKです.</span>
                        </div>                    

                        <!--　中学校 -->
                        <div class="col-xs-12 form-group">
                            <label for="junior_high_school" class="control-label">出身中学</label>                    
                            <select name="junior_high_school" id="junior_high_school" class="form-control" x-autocompletetype="region">
                                <option value="" selected="selected">-- 出身中学 --</option>
                                
                                <option value="木屋瀬">木屋瀬</option>
                                <option value="引野">引野</option>
                                <option value="岡垣">岡垣</option>
                                <option value="0">不明</option>
                            </select>
                        </div>

                        <!--　部活動 -->
                        <div class="col-xs-12 form-group">
                            <label for="club" class="control-label">部活動</label>           
                            <select v-model="club" options="items" class="form-control" x-autocompletetype="region">
                                <option value="" selected="selected">-- 部活動 --</option>
                                <option v-for="club in clubs">
                                    {{ club }}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button v-show="editmode" type="submit" class="btn btn-success">Update</button>
                        <button v-show="!editmode" type="submit" class="btn btn-primary">Create</button>
                    </div>
                  </form>

              </div>
              <!-- /.card-body -->
                          
              <div class="card-footer">

              </div>
            </div>
            <!-- /.card -->
          </div>
        </div>
    </div>
  </section>
</template>

<script>
    import VueTagsInput from '@johmun/vue-tags-input';

    export default {
      components: {
          VueTagsInput,
        },
        data () {
            return {
                editmode: false,
                members : {},
                current_page: 1,
                last_page: 1,
                total: 1,
                from: 0,
                to: 0,
                keyword: '',
                search_item: 'name',
                categories: [],
                form: new Form({
                    id : '',
                    category : '',
                    name: '',
                    description: '',
                    tags:  [],
                    photo: '',
                    category_id: '',
                    price: '',
                    photoUrl: '',
                }),

                tag:  '',
                autocompleteItems: [],
                                   graduate : '',
                address : '',
                pref : '',
                clubs : [
                    '吹奏楽','ボート','野球',
                ],
                regions : [
                    '北海道','東北','関東','北陸','中部','関西','中国','四国','九州'
                ],
                prefs : [
                    ['北海道'],
                    ['青森県','岩手県','宮城県','秋田県','山形県','福島県'],
                    ['茨城県','栃木県','群馬県','埼玉県','千葉県','東京都','神奈川県'],
                    ['新潟県','富山県','石川県','福井県'],
                    ['山梨県','長野県','岐阜県','静岡県','愛知県'],
                    ['三重県','滋賀県','京都府','大阪府','兵庫県','奈良県','和歌山県'],
                    ['鳥取県','島根県','岡山県','広島県','山口県'],
                    ['徳島県','香川県','愛媛県','高知県'],
                    ['福岡県','佐賀県','長崎県','熊本県','大分県','宮崎県','鹿児島県','沖縄県']
                ],
                zip: '',
                graduate_youngest: '',
                graduates : []
            }
        },
        watch: {
            zip: function (zipcode) {
                var url = '/api/zip2address?zipcode=' + zipcode ;                
                var app = this;

                axios.get(url)
                .then(function (resp) {
                    if (resp.data.results != null) {
                        var address = resp.data.results[0].address2 + 
                                    resp.data.results[0].address3 ;
                        app.pref = resp.data.results[0].address1 ;
                        app.address = address ;
                    }
                })
                .catch(function (resp) {
                    console.log(resp);
                });
            }
        },
        methods: {
            saveForm() {
            },
            createGraduateTable: function() {
                var _year = 1942 ;
                var max_year = new Date().getFullYear();

                for (;_year <= max_year;_year++) {
                    var _graduate = _year - 1902 ;
                    var _gengo = '' ;

                    if (_year <= 1988) {
                        _gengo = '昭和' + String(_year - 1925) + '年';
                    } else
                    if (_year <= 2018) {
                        _gengo = '平成' + String(_year - 1988) + '年';
                    } else {
                        _gengo = '令和' + String(_year - 2018) + '年';
                    }
                    this.graduates.push({ value : String(_graduate),
                                        string : String(_year) + '年/' + _gengo + '卒' });
                }
            }

        },
        mounted() {
            
        },
        created() {
            this.createGraduateTable();
        },
        filters: {
            truncate: function (text, length, suffix) {
                return text.substring(0, length) + suffix;
            },
        },
        computed: {
          filteredItems() {
            return this.autocompleteItems.filter(i => {
              return i.text.toLowerCase().indexOf(this.tag.toLowerCase()) !== -1;
            });
          },
        }
    }
</script>
