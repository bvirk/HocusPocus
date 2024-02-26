import * as dlg from "./dialog.js";
import * as keyb from "./keyboard.js";
import { postString } from "../jslib/request.js";
import { submitAll } from "./formsubmit.js";
import * as rsp from "./reqCallBacks.js";

allFuncs.saveContent = function(filetoedit) {
    postString(dlg.APIName,'saveFile',filetoedit,$("#contentdiv").text(),rsp.savedFileResponse);
}
keyb.setCurkeyhandler(keyb.KeyHandler.NOMENU);
allFuncs.hamDrawMenu = dlg.hamDrawMenu;
allFuncs.submitAll = submitAll;
allFuncs.cdtonum = dlg.cdtonum;
allFuncs.cdback = dlg.cdback;
allFuncs.cdhome = dlg.cdhome;
allFuncs.close = dlg.quitMenu;
allFuncs.toEditMode = dlg.toEditMode;

/*
new object and their responsibilities

Dirlist (holds the dirlist, and reports about and draw itselv
    vars:
        loggedInOwns
        obj: Line[]
        selected
  
    methods:
        void Draw()
        void up()
        void down()
        void invertline()
        obj selected()
        void rm()
        void rmDir()



Line
    vars:
        name:
        isDirTag:
        desc:
        hierStr
        owedByLoggedIn
    method:
        void rename()

*/
