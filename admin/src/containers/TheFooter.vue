<template>
  <CFooter :fixed="false">
    <div>
      <a href="https://samourt.com/" target="_blank">SAMOURT</a>
      <span class="ml-1">&copy; {{new Date().getFullYear()}} Todos los derechos reservados.</span>
    </div>
    <div class="mfs-auto">
      <span class="mr-1" target="_blank">Creado por</span>
      <a href="https://samourt.com/" target="_blank">SAMOURT</a>
    </div>
  </CFooter>
</template>

<script>
export default {
  name: 'TheFooter'
}
</script>
