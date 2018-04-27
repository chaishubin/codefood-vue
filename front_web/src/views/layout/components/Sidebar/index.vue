<template>
  <scroll-bar>
    <el-menu mode="vertical" unique-opened router :default-active="onRoutes" :collapse="isCollapse"  background-color="#304156" text-color="#fff" active-text-color="#409EFF">
      <sidebar-item></sidebar-item>
    </el-menu>
  </scroll-bar>
</template>

<script>
import SidebarItem from './SidebarItem'
import ScrollBar from '@/components/ScrollBar'

export default {
  components: { SidebarItem, ScrollBar },
  computed: {
    isCollapse() {
      return false;
    },
    onRoutes(){
        return this.$route.path.replace('/','');
    }
  }
}
</script>
