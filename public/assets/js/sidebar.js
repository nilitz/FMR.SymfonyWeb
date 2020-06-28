function onSidebarButtonClick(){

    let sidebar = document.querySelector('div.sidebar')
    let sidebar_btn = document.querySelector('div.sidebar-btn')

    sidebar.classList.toggle("sidebar-visible")
    sidebar_btn.classList.toggle("btn-visible")
}

btn = document.querySelector('div.sidebar-btn')
btn.addEventListener('click', onSidebarButtonClick)


