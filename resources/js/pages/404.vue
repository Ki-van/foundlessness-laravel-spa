<template>
    <div class="block">
        <div class="art-post-body">
            <h3>Страница {{prevRoute.fullPath === '/'? route.fullPath: prevRoute.fullPath}} не найдена</h3>
            <div class="art-post-content">
                <p>
                    Если вы уверенны, что данная страница должна "существовать", но это не так по ошибке, пожалуйста, напишите на <a> kirill.ivanin00@yandex.ru</a>
                </p>
            </div>
            <vue-title title="Страница не найдена"></vue-title>
        </div>
    </div>
</template>

<script>
export default {
    name: "404",
    data(){
      return {
          prevRoute: '',
          route: ''
      }
    },
    computed: {
      path(){
          if(this.prevRoute.fullPath === '/'){
              if( this.route.fullPath === '/404')
                  return ''
              else
                  return this.route.fullPath;
          } else
              return this.prevRoute.fullPath;

      }
    },
    beforeRouteEnter(to, from, next) {
        next(vm => {
            vm.prevRoute = from;
            vm.route = to;
        })
    },
}
</script>

