const drop_area = document.querySelectorAll(".drop_area");

for (i = 0; i < drop_area.length; i++) { /* drop_area is an array (QuerySelectorAll) */

const cur = drop_area[i];
cur.addEventListener("dragover", (e) => {
    e.preventDefault();
    cur.classList.add("drop_hover");
});

cur.addEventListener("dragleave", () => {
    cur.classList.remove("drop_hover");
});

cur.addEventListener("drop", (e) => {
    e.preventDefault(); /* prevent default action - open file */
    const image = e.dataTransfer.files[0];
    const type = image.type;
	
    console.log(type); /* debug */
    console.log(image.name); 	
    if ( type == "image/png" || type == "image/jpg" || type == "image/jpeg" || type == "image/gif" ) {
	cur.innerText = image.name;	
    } else {
        cur.innerText = "Invalid File Format!";
    } 
});
}

