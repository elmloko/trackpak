import { search } from "./export_search.js";
const mysearchp = document.querySelector("#mysearch");
const ul_add_lip = document.querySelector("#showlist");
const myurlp = "http://127.0.0.1:8000/api/search";
const searchproduct = new search(myurlp, mysearchp, ul_add_lip);
searchproduct.InputSearch();


