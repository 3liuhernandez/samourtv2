export default [
  {
    _name: 'CSidebarNav',
    _children: [
      {
        _name: 'CSidebarNavItem',
        name: 'Tablero',
        to: '/dashboard',
        icon: 'cil-speedometer'
      },
      {
        _name: 'CSidebarNavTitle',
        _children: ['Gestión']
      },
      {
        _name: 'CSidebarNavItem',
        name: 'Usuarios',
        to: '/users',
        icon: 'cil-calendar'
      },
      {
        _name: 'CSidebarNavItem',
        name: 'Categorías',
        to: '/categories',
        icon: 'cil-calendar'
      },
      {
        _name: 'CSidebarNavItem',
        name: 'Música',
        to: '/products',
        icon: 'cil-calendar'
      },
      
    ]
  }
]