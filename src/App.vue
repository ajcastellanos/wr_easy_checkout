<template>

  <el-col class="container-fluid wrech-admin-main p-0 m-0" v-loading="loading">
    <el-row class="tac">
      <el-col :span="6" class="wrech-sidebar">
        <el-menu
                default-active="2"
                class="el-menu-vertical-main"
        >

          <el-menu-item index="2" @click="changeScreen('cart')">
            <el-icon><shopping-cart /></el-icon>
            <span>Cart Modal</span>
          </el-menu-item>
          <el-menu-item index="3" @click="changeScreen('settings')">
            <el-icon><setting /></el-icon>
            <span>Settings</span>
          </el-menu-item>
          <el-menu-item index="4" disabled>
            <el-icon><help /></el-icon>
            <span>License and Support</span>
          </el-menu-item>
        </el-menu>
      </el-col>
      <el-col :span="18" class="main-area">

       <div class="cart" v-show="active_screen === 'cart'">

         <p class="wrech-label"><strong>Cart Icon:</strong></p>
         <p>Define the cart float button icon</p>
         <el-upload
                 ref="upload"
                 :action="ajax_url"
                 :data="file_data"
                 list-type="picture-card"
                 accept="image/png, image/jpeg"
                 :file-list="uploaded_files"
                 :limit="1"
                 :on-exceed="handleExceed"
                 :on-success="iconUploaded"
                 :on-progress="iconUploading"
                 :on-error="iconUploadError"
                 :on-change="fileChanged"
                 :on-remove="defaultIcon"
                 class="wrech_single_uploader"
         >
           <el-icon><plus /></el-icon>
         </el-upload>

         <br>

         <p class="wrech-label"><strong>Design: </strong> <a target="_blank" :href="`${site_url}/wp-admin/customize.php?wrech_customizer=yes&autofocus%5Bpanel%5D=wrech_mod_main`">Go to Customizer</a></p>

       </div>
        <div class="settings" v-show="active_screen === 'settings'">
          <p class="wrech-label"><strong>Excluded Pages:</strong></p>

          <el-select v-model="excluded_pages"  multiple placeholder="Select Pages" size="large" class="wrech-select">
            <el-option
                    v-for="page in pages"
                    :key="page.ID"
                    :label="page.post_title + ' ID: ' +page.ID"
                    :value="page.ID"
            >
            </el-option>
          </el-select>
          <p class="wrech-field-description mt-3">List pages where the cart modal won't show, Cart and checkout page are excluded by default.</p>
        </div>

        <br>
        <el-button type="primary" @click="saveCustomization()" round>Save Settings <el-icon class="el-icon--right"> <check /></el-icon></el-button>
    </el-col>
  </el-row>
  </el-col>
</template>

<script>
  const axios = require('axios');
  import { Check, Plus,Setting,ShoppingCart, Help, List } from '@element-plus/icons-vue';
  import { ElMessage } from 'element-plus';

  export default {
    components:{
      Check,Plus,Setting, ShoppingCart, Help, List
    },
    data() {
      return {
        loading: false,
        cart_icon: null,
        uploaded_files: [{
          url: wrech_settings_params.settings.cart_icon_url
        }],
        file_data: {
          action: 'wrech_add_cart_icon'
        },
        plugin_url: wrech_settings_params.plugin_url,
        ajax_url: wrech_settings_params.ajax_url,
        site_url: wrech_settings_params.site_url,
        active_screen: 'cart',
        pages: [],
        excluded_pages: [],
      }
    },
    computed:{

    },
    created(){
      this.getPages();
    },
    methods:{
      changeScreen(screen){
        this.active_screen = screen;
      },
      handleExceed(files){
        this.$refs.upload.clearFiles()
        this.$refs.upload.handleStart(files[0])
        this.$refs.upload.submit()
      },
      iconUploadError(err){
        this.loading = false;
      },
      iconUploading(){
        this.loading = true;
      },
      iconUploaded(response,file, fileList){
        this.loading = false;
      },
      defaultIcon(){
        const formData = new FormData();
        formData.append('action', 'wrech_default_icon');
        this.loading = true;
        axios.post(wrech_settings_params.ajax_url, formData)
                .then( response => {
                  if(response.data.success){
                    ElMessage.success('Cart Icon Defaulted!')
                  }else{
                    ElMessage.error(response.data.msg)
                  }

                });
        this.loading = false;
      },
      saveCustomization(){
        const formData = new FormData();
        formData.append('action', 'wrech_save_customizations');
        formData.append('excluded_pages', this.excluded_pages);

        this.loading = true;
        axios.post(wrech_settings_params.ajax_url, formData)
            .then( response => {
              if(response.data.success){
                ElMessage.success('Settings Saved!')
              }else{
                ElMessage.error(response.data.msg)
              }
              this.loading = false;
        });
      },
      getPages(){
        const formData = new FormData();
        formData.append('action', 'wrech_get_pages');
        this.loading = true;
        axios.post(wrech_settings_params.ajax_url, formData)
            .then( response => {
              if(response.data.success){
                this.pages = response.data.pages;
                this.excluded_pages = response.data.excluded_pages;
              }else{
                ElMessage.error(response.data.msg)
              }
        });
        this.loading = false;
      }
    }
  }
</script>

<style>
  #wrech-app{
    background: #eef1f5 !important;
    height: 100vh;
  }

  .toplevel_page_wrech-test .notice{
    display: none !important;
  }

  .wrech-sidebar .panel-wrapper{
    height: 100vh;
  }

  .box-panel .panel-wrapper {
    background: white;
    border-radius: 8px;
    color: #78849c;
    padding: 50px 20px;
  }

  .position_image{
    width: 60px;
  }

  .btn_position{
    margin-right: 50px;
  }

  .btn_position .el-radio-button__inner{
    padding: 5px;
  }

  .btn_position[aria-checked='true']{
    border-radius: 5px;
    -webkit-box-shadow: 1px 2px 8px 0px rgba(0,0,0,0.62);
    box-shadow: 1px 2px 8px 0px rgba(0,0,0,0.62);
  }

  .wrech_single_uploader .el-upload--picture-card, .wrech_single_uploader .el-upload-list--picture-card .el-upload-list__item{
    width: 60px !important;
    height: 60px !important;
  }

  .wrech_single_uploader .el-upload--picture-card i{
    margin-top: 20px !important;
    font-size: 18px !important;
  }

  .wrech_single_uploader .el-upload-list__item-preview{
    display: none !important;
  }

  .wrech_single_uploader .el-upload-list--picture-card .el-upload-list__item-actions span+span{
    margin-left: 0 !important;
  }

  .el-menu-vertical-main{
    height: 100vh !important;
  }

  .main-area{
    padding: 20px !important;
  }

  .wrech-select{
    width: 400px;
  }

  .wrech-field-description{
    font-style: italic;
  }

</style>
