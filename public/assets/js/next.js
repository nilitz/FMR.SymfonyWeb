function onClickStatusBtn(event)
{
    event.preventDefault()

    const url = this.href
    const a = this
    console.log(url)
    console.log(a)

    axios.get(url).then(function (response) {
        if(a.classList.contains('status-1')) {
            a.classList.replace('status-1', 'status-2')
        }
        else if(a.classList.contains('status-2')) {
            a.classList.replace('status-2', 'status-3')
        }
        else if(a.classList.contains('status-3')) {
            a.classList.replace('status-3', 'status-4')
        }
    }).catch(error => {
    console.log(error.message);
    })

}
document.querySelectorAll('a.crud-status-button').forEach(function (link) {
    link.addEventListener('click', onClickStatusBtn)
})