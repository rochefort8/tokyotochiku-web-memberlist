

import VueTagsInput from '@johmun/vue-tags-input';

export default {
  name: 'VueMemberList',
  components: {
      VueTagsInput,
    },
    data () {
        return {
            members : {},
            current_page: 1,
            last_page: 1,
            total: 1,
            from: 0,
            to: 0,
            keyword: '',
            search_item: 'name',
        }
    },
    watch: {
      keyword: function (q) {
        this.keyword = q ;
        this.loadMembers() ;
      },
    },
    methods: {
      loadMembers(page = 1){
          var app = this;
          var url = '/api/member?page=' + page ;

          if (this.keyword != "") {
              url = url + '&' + this.search_item + '=' + this.keyword;
          }
          axios.get(url).then(({ data }) => (this.members = data.data));
      },
      updateOption(option,text) {
          this.search_item = option;
          $('.search-panel span#search_concept').text(text);
          this.keyword = '';
          this.loadMembers();
      },
    },
    mounted() {
        
    },
    created() {
        this.$Progress.start();
        this.loadMembers();
        this.$Progress.finish();
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
