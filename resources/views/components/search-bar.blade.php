<div id="search-bar-component">
    <input id="search-bar" name="search_term" type="text" placeholder="Search" style="width: {{ $width }}" />
    <div id="dropdown-menu" role="listbox"></div>
</div>

@if ($useCss)
<style>
#search-bar-component {
    position: relative;
}
#search-bar-component input#search-bar {
    display: block;
    right: 0;
    cursor: text;
    height: 2rem;
    color: #4e6e8e;
    border: 1px solid #cfd4db;
    border-radius: 2rem;
    font-size: .9rem;
    line-height: 2rem;
    padding: 0 1rem;
    outline: 0;
    background-size: auto;
    background-size: 1rem;
    transition: all .2s ease;
}
#search-bar-component #dropdown-menu {
    display: none;
    position: absolute;
    top: 2rem;
    right: 0;
    border-radius: 1rem;
    text-align: left;
    min-width: 400px;
    background: #fff;
    border: 1px solid #cfd4db;
    transition: all .2s ease;
}
#search-bar-component #dropdown-menu .result-link {
    display: block;
    padding: .750rem 1rem;
    font-size: .875rem;
    
}
#search-bar-component #dropdown-menu .result-link:hover,
#search-bar-component #dropdown-menu .result-link:active {
    background-color: #f1f2f4;
}
#search-bar-component #dropdown-menu .result-header,
#search-bar-component #dropdown-menu .result-empty {
    padding: 1rem;
    width: 100%;
}
#search-bar-component #dropdown-menu .result-header {
    border-bottom: 1px solid #cfd4db;
}
</style>
@endif

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        
        function debounce(func, wait, immediate) {
            var timeout;
            return function() {
                var context = this, args = arguments;
                var later = function() {
                    timeout = null;
                    if (!immediate) func.apply(context, args);
                };
                var callNow = immediate && !timeout;
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
                if (callNow) func.apply(context, args);
            };
        };
        
        document.onclick = function(event){
            if(event.target.id !== document.getElementById('dropdown-menu')){
              document.getElementById('dropdown-menu').style.display = 'none';
            }
        };
        
        document.getElementById('search-bar').addEventListener('keyup', debounce(function(event) {
            
            httpRequest = new XMLHttpRequest();
            httpRequest.open('POST', '/search');
            httpRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            if (event.target.value.length) httpRequest.send(new URLSearchParams({'search_term': event.target.value, 'search_namespace': "{!! $namespace !!}"}).toString());
            
            httpRequest.onreadystatechange = function() {
                if (httpRequest.readyState === XMLHttpRequest.DONE) {
                    if (httpRequest.status === 200) {
                        var response = JSON.parse(httpRequest.responseText);
                        document.getElementById('dropdown-menu').innerHTML = "";
                        if (response.success) {
                            if (typeof response.results === 'object') {
                                for (const [key, tableResults] of Object.entries(response.results)) {
                                    var resultHeader = ((tableResults.length) && (typeof tableResults[0].search_header_format !== 'undefined')) ? tableResults[0].search_header_format : key;
                                    document.getElementById('dropdown-menu').insertAdjacentHTML('beforeend', 
                                        '<div class="result-header">'+resultHeader+'</div>'
                                    );
                                    for (const [idx, result] of Object.entries(tableResults)) {
                                        document.getElementById('dropdown-menu').insertAdjacentHTML('beforeend', 
                                            '<a href="'+((typeof result.search_url !== 'undefined') ? result.search_url : '#')+'" class="result-link" target="_blank"><div>'+((typeof result.search_result_format !== 'undefined') ? result.search_result_format : 'Search Result Format Not Set')+'</div></a>'
                                        );
                                    }
                                }
                            } else {
                                document.getElementById('dropdown-menu').insertAdjacentHTML('beforeend', 
                                    '<div class="result-empty">No Results Found</div>'
                                );
                            }
                            document.getElementById('dropdown-menu').style.display = 'block';
                        }
                    }
                }
            }
                
        }, "{!! $debounce !!}"), false);
        
    });
</script>