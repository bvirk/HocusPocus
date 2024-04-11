import {IS_PHP_ERR } from './webPageContext.js'
import { getRequest } from './requests.js';
import { APIName } from './webPageContext.js'
import { wRPath } from './dirView.js';
import { dirname } from './dirView.js';

let cache;
let dirty=true;
let dirdir;
let dircache = {};

export function cacheSelFile() {
    const pattern = new RegExp(`^${dirdir}/`);
    Object.keys(dircache)
        .filter(key => pattern.test(key))
        .forEach(key => delete dircache[key]);
    dircache[dirdir] = this.selIndex;
}

export function clearDirCache() {
    for (const key in dircache) 
        if (dircache.hasOwnProperty(key)) 
            delete dircache[key];
}

export function dirlistData(drawer) {
    if (dirty) 
        getRequest(drawer,APIName+'lsWithPath&curdir='+wRPath);
    else
        drawer(cache,true);
}

export function fileItem(index) {
    return cache[this.dirIndex][index];
}

//export function freeze() {
//    let fileName=cache[this.dirIndex][this.selIndex][0];
//    if (this.frozen.length)
//        this.frozen[this.frozen.length-1] = fileName
//    else
//        this.frozen.push(fileName);
//}

export function getCachedDir() {
    console.log(dircache);
    //return dircache.dirdir;
}


export function selFileItem() {
    return dirty ? "no valid cache" : this.fileItem(this.selIndex);
}


export function setDirty() { dirty=true; this.selIndex=0; return module;}

export function store(newcache,newDirty) {
    cache=newcache;
    dirty=newDirty;
    this.length = cache[this.dirIndex].length;
    dirdir = dirname(cache[this.dirIndex][0][0]);
    this.selIndex = dirdir in dircache ? dircache[dirdir] : 0;
    this.cacheSelFile();
    
}

const module = { cacheSelFile, clearDirCache, dirHasDir:null, dirIndex: 2, dirPermStat:null, getCachedDir, length: 0, selIndex: 0, dirlistData, fileItem, selFileItem, setDirty, store };
export default module;
/*
on store: this.dirdir = dirname(file[0])
after cursor down and up
    entry in dircache
        dir: file
cursor right:
    dir: file[0]
cursor left
    remove dir
*/