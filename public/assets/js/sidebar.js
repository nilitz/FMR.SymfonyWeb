function onSidebarButtonClick(){

    let sidebar = document.querySelector('div.sidebar')
    let sidebar_btn = document.querySelector('div.sidebar-btn')
    let page_content = document.querySelector('div.page-content')

    if (sidebar.classList.contains("sidebar-partially-visible"))
    {
        sidebar.classList.toggle("sidebar-partially-visible")
        sidebar.classList.toggle("sidebar-visible")
        sidebar_btn.classList.toggle("btn-partially-visible")
        sidebar_btn.classList.toggle("btn-visible")
        page_content.classList.toggle("bloom")
    }
    else if (sidebar.classList.contains("sidebar-visible"))
    {
        page_content.classList.toggle("bloom")
        page_content.classList.toggle("reduce")
        sidebar.classList.toggle("sidebar-visible")
        sidebar_btn.classList.toggle("btn-visible")
    }
    else
    {
        sidebar.classList.toggle("sidebar-partially-visible")
        sidebar_btn.classList.toggle("btn-partially-visible")
        page_content.classList.toggle("reduce")
    }
}

btn = document.querySelector('div.sidebar-btn')
btn.addEventListener('click', onSidebarButtonClick)


