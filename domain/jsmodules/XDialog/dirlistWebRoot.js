import {IS_PHP_ERR } from './webPageContext.js'
import { getRequest } from './requests.js';
import {APIName } from './webPageContext.js'
import { wRPath } from './dirView.js';

let cache;
let dirty=true;

export function dirlistData(drawer) {
    if (dirty) 
        getRequest(drawer,APIName+'lsWithPath&curdir='+wRPath);
    else
        drawer(cache,true);
}

export function fileItem(index) {
    return cache[this.dirIndex][index];
}

export function selFileItem() {
    return dirty ? "no valid cache" : this.fileItem(this.selIndex);
}


export function setDirty() { dirty=true; this.selIndex=0; return module;}

export function store(newcache,newDirty) {
    cache=newcache;
    this.length = cache[this.dirIndex].length;
    dirty=newDirty;
}

const module = { dirHasDir:null, dirIndex: 2, dirPermStat:null,length: 0, selIndex: 0, dirlistData, fileItem, selFileItem, setDirty, store };
export default module;