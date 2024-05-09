import { postRequest } from './requests.js';
import { APIClass } from './webPageContext.js'
import { wRPath, dirname } from './dirView.js';
import { barename } from './filemanage.js';

let cache;
let dirty=true;
let dirdir;
let dircache = {};
let navigateToUrlPath=false;

 function cacheSelFile() {
    const pattern = new RegExp(`^${dirdir}/`);
    Object.keys(dircache)
        .filter(key => pattern.test(key))
        .forEach(key => delete dircache[key]);
    dircache[dirdir] = this.selIndex;
}

 function clearDirCache() {
    for (const key in dircache) 
        if (dircache.hasOwnProperty(key)) 
            delete dircache[key];
    dircache = {};

}

 function dirlistData(drawer) {
    if (dirty) 
        postRequest(drawer,{curdir:wRPath},APIClass+'ls');
    else
        drawer(cache,true);
}

 function fileItem(index) {
    return cache['dirlist'][index];
}

 function getCachedDir() {
    console.log(dircache);
    //return dircache;
}

 function getUrlIndex() {
    let num=0;
    let lastUrlPart = location.pathname.split('/').reverse()[0];
    cache.dirlist.forEach((element,index) => {
        if ( lastUrlPart === barename(element.file))
            num = index;
    });
    return num;
}

 function selFileItem() {
    return dirty ? "WR - no valid cache" : this.fileItem(this.selIndex);
}
 function selPathParts() {
    return cache['dirlist'][this.selIndex].file.split('/').length-1;
}

/**
 * 
 * @returns module
 */
function setDirty() { 
    dirty=true;
    return module;
}

function setNextSelNum(num) {
    this.nextSelNum=selNum;
    return module;
}


function store(newcache) {
    cache=newcache;
    dirty=false;
    this.length = newcache['dirlist'].length;
    this.permstat = newcache.permstat;
    dirdir = dirname(cache['dirlist'][0].file);
    if ( this.nextSelNum) {
        this.selIndex = this.nextSelNum-1;
        this.nextSelNum=0;
    } else if (navigateToUrlPath) {
        navigateToUrlPath=false;
        this.selIndex = getUrlIndex();
    } else if (dirdir in dircache) {
        this.selIndex = dircache[dirdir];
    } else
        this.selIndex=0;
    this.cacheSelFile();
}

function useUrlPath() {
    navigateToUrlPath=true;
    return module;
}

const module = { cacheSelFile, clearDirCache, 
    getCachedDir, length: 0, nextSelNum: 0, selIndex: 0, dirlistData, fileItem, permstat:0, selFileItem, setNextSelNum, selPathParts, setDirty, store, useUrlPath };
 export default module;
