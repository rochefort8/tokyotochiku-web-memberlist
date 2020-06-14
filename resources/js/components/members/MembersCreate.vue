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
                        <div class="form-group">
                            <label>Name</label>
                            <input v-model="form.name" type="text" name="name"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                            <has-error :form="form" field="name"></has-error>
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <input v-model="form.description" type="text" name="description"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('description') }">
                            <has-error :form="form" field="description"></has-error>
                        </div>
                        <div class="form-group">
                            <label>Price</label>
                            <input v-model="form.price" type="text" name="price"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('price') }">
                            <has-error :form="form" field="price"></has-error>
                        </div>
                        <div class="form-group">

                            <label>Category</label>
                            <select class="form-control" v-model="form.category_id">
                              <option 
                                  v-for="(cat,index) in categories" :key="index"
                                  :value="index"
                                  :selected="index == form.category_id">{{ cat }}</option>
                            </select>
                            <has-error :form="form" field="category_id"></has-error>
                        </div>
                        <div class="form-group">
                            <label>Tags</label>
                            <vue-tags-input
                              v-model="form.tag"
                              :tags="form.tags"
                              :autocomplete-items="filteredItems"
                              @tags-changed="newTags => form.tags = newTags"
                            />
                            <has-error :form="form" field="tags"></has-error>
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
            }
        },
        watch: {
          keyword: function (q) {
            var app = this;
            axios.get('/api/member?' + this.search_item + '=' + q)
              .then(({ data }) => (this.members = data.data));	   
          },
        },
        methods: {
            saveForm() {
            },
        },
        mounted() {
            
        },
        created() {
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
