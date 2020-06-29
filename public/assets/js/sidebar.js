function onSidebarButtonClick(){

    let sidebar = document.querySelector('div.sidebar')
    let sidebar_btn = document.querySelector('div.sidebar-btn')
    if (sidebar.classList.contains("sidebar-partially-visible"))
    {
        sidebar.classList.toggle("sidebar-partially-visible")
        sidebar.classList.toggle("sidebar-visible")
        sidebar_btn.classList.toggle("btn-partially-visible")
        sidebar_btn.classList.toggle("btn-visible")
    }
    else if (sidebar.classList.contains("sidebar-visible"))
    {
        sidebar.classList.toggle("sidebar-visible")
        sidebar_btn.classList.toggle("btn-visible")
    }
    else
    {
        sidebar.classList.toggle("sidebar-partially-visible")
        sidebar_btn.classList.toggle("btn-partially-visible")
    }
}

btn = document.querySelector('div.sidebar-btn')
btn.addEventListener('click', onSidebarButtonClick)


