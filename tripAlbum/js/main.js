document.addEventListener('DOMContentLoaded', function () {
    var grid = null,
        wrapper = document.querySelector('.grid-wrapper'),
        filterField = wrapper.querySelector('.filter-field'),
        gridElem = wrapper.querySelector('.grid'),
        filterAttr = 'data-color',
        filterFieldValue;

    // Init the grid layout
    grid = new Muuri(gridElem, {
        dragEnabled: true
    });

    filterFieldValue = filterField.value;
    console.log("filterFieldValue⇒"+filterFieldValue+";");

    // Filter field event binding
    filterField.addEventListener('change', filter);

    // Filtering
    function filter() {
        filterFieldValue = filterField.value;
        // filterFieldValue = "";
        console.log("filter filterFieldValue⇒"+filterField.value+";");
        grid.filter(function (item) {
            var element = item.getElement(),
            //""だとfalse、!""だとtrue。以下はtrue
            // isFilterMatch = !filterFieldValue ? true : false;
            // isFilterMatch = (element.getAttribute(filterAttr) || '') === filterFieldValue;
            isFilterMatch = !filterFieldValue ? true : element.getAttribute(filterAttr) === filterFieldValue;
            // return isSearchMatch && isFilterMatch;
            console.log("aaa:"+isFilterMatch+";");
            console.log("bbb:"+element.getAttribute(filterAttr)+";");
            return isFilterMatch;
        });
    }

});