<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
      <li class="nav-item">
        <router-link to="/dashboard" class="nav-link">
          <i class="nav-icon fas fa-tachometer-alt blue"></i>
          <p>
            Dashboard
          </p>
        </router-link>
      </li>

      <!--  
      <li class="nav-item">
        <router-link to="/products" class="nav-link">
          <i class="nav-icon fas fa-list orange"></i>
          <p>Product</p>
        </router-link>
      </li>
      -->

      <li class="nav-item">
        <router-link to="/members" class="nav-link">
          <i class="nav-icon fas fa-list orange"></i>
          <p>{{ __('strings.menu.members') }}</p>
        </router-link>
      </li>

      <li class="nav-item">
        <router-link to="/annualfee" class="nav-link">
          <i class="nav-icon fas fa-list orange"></i>
          <p>年会費</p>
        </router-link>
      </li>

      <li class="nav-item">
        <router-link to="/newsletter" class="nav-link">
          <i class="nav-icon fas fa-list orange"></i>
          <p>会報送付</p>
        </router-link>
      </li>

 <!--
      <li class="nav-item has-treeview">
        <a href="#" class="nav-link">
          <i class="nav-icon fas fa-list green"></i>
          <p>{{ __('strings.menu.members') }}
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">

          <li class="nav-item">
            <router-link to="/members" class="nav-link">
              <i class="nav-icon fas fa-list-ol green"></i>
              <p>基本操作
              </p>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link to="/product/tag" class="nav-link">
              <i class="nav-icon fas fa-tags green"></i>
              <p>年会費
              </p>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link to="/developer" class="nav-link">
                <i class="nav-icon fas fa-cogs white"></i>
                <p>会報送付
                </p>
            </router-link>
          </li>
        </ul>
      </li>
-->
      @can('isAdmin')
        <li class="nav-item">
          <router-link to="/users" class="nav-link">
            <i class="fa fa-users nav-icon blue"></i>
            <p>ユーザ管理</p>
          </router-link>
        </li>
      @endcan

      @can('isAdmin')
      <li class="nav-item has-treeview">
        <a href="#" class="nav-link">
          <i class="nav-icon fas fa-cog green"></i>
          <p>
            設定
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <!--
          <li class="nav-item">
            <router-link to="/product/category" class="nav-link">
              <i class="nav-icon fas fa-list-ol green"></i>
              <p>
                Category
              </p>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link to="/product/tag" class="nav-link">
              <i class="nav-icon fas fa-tags green"></i>
              <p>
                Tags
              </p>
            </router-link>
          </li>
          -->

          <li class="nav-item">
            <router-link to="/member/club" class="nav-link">
              <i class="nav-icon fas fa-list-ol green"></i>
              <p>
                部活動
              </p>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link to="/member/juniorhighschool" class="nav-link">
              <i class="nav-icon fas fa-tags green"></i>
              <p>
                出身中学
              </p>
            </router-link>
          </li>

            <li class="nav-item">
              <router-link to="/developer" class="nav-link">
                  <i class="nav-icon fas fa-cogs white"></i>
                  <p>
                      Developer
                  </p>
              </router-link>
            </li>
        </ul>
      </li>

      @endcan
      
      

      <li class="nav-item">
        <a href="#" class="nav-link" onclick="event.preventDefault();
          document.getElementById('logout-form').submit();">
          <i class="nav-icon fas fa-power-off red"></i>
          <p>
            {{ __('Logout') }}
          </p>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
          @csrf
        </form>
      </li>
    </ul>
  </nav>