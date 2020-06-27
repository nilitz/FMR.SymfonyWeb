function onSidebarButtonClick(){

    let sidebar = document.querySelector('div.sidebar')
    sidebar.classList.toggle("visible")
    console.log(sidebar.classList)

}

btn = document.querySelector('div.sidebar-btn')
btn.addEventListener('click', onSidebarButtonClick)


