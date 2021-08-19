var gitalk = new Gitalk({
  clientID: '2eb19afceda708b27e64', // GitHub Application Client ID
  clientSecret: '36aedb5a30321626a8631689fee5fafd5929f612', // GitHub Application Client Secret
  repo: 'gitalk-comment'      // 存放评论的仓库
  owner: 'yulilong',          // 仓库的创建者，
  admin: ['yulilong'],        // 如果仓库有多个人可以操作，那么在这里以数组形式写出
  id: location.pathname,      // 用于标记评论是哪个页面的，确保唯一，并且长度小于50
})

gitalk.render('gitalk-container');    // 渲染Gitalk评论组件