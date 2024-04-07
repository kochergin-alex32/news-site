document.querySelector('#sort').addEventListener('change', function (e) {
    fetch("handlers/handler.php",{
        method: "POST",
        body:JSON.stringify({param:"getFavourites"}),
        
    }).then(resp=>resp.json()).then((res)=> {
        if(res === false){
            alert('ошибка получения постов')
        } else {
            // нужная штука для сортировки
            res.sort((a,b) => {
                const aDate = new Date(a.publishedAt)
                const bDate = new Date(b.publishedAt)
                if(e.target.value === 'desc'){

                    return bDate - aDate;
                } else {
                    return aDate - bDate;
                }
            })

           
            document.querySelector('.blog-list').innerHTML = ''
           let out = '';
            res.forEach((post) => {
            
                const postOutput  = `
                <div class="blog-box row">
                <div class="col-md-4">
                    <div class="post-media">
                        <a href="${post.url}" title="">
                            <img src="${post.urlToImage || 'images/noimg.png'}" alt="не загрузилось" class="img-fluid">
                            <div class="hovereffect"></div>
                        </a>
                    </div>
                </div>

                <div class="blog-meta big-meta col-md-8">
                    <h4><a href=${post.url}" title="">${post.title} </a></h4>
                    <p>${post.description}</p>

                  

                    <small><a href="tech-single.html" title=""> 
                    ${new Date(post.publishedAt).toUTCString()}
                                </a></small>
                                ${post.author ? ` <small><a href="tech-author.html" title="">${post.author}</a></small> `: ''}
                               
                   
                
                </div>
            </div>
                `;
                out += postOutput;
            });

            document.querySelector('.blog-list').insertAdjacentElement('afterbegin', out)

        }
    });
});