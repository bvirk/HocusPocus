import { hamDrawMenu,cdback,cdhome,cdtonum,toEditMode,APIName,quitMenu } from "./hamMenu.js";
import { setCurkeyhandler, KeyHandler } from "./keyboard.js";
import { postString } from "../jslib/request.js";
import { submitAll } from "./formsubmit.js";
import { savedFileResponse } from "./reqCallBacks.js";

allFuncs.saveContent = function(filetoedit) {
    postString(APIName,'saveFile',filetoedit,$("#contentdiv").text(),savedFileResponse);
}
setCurkeyhandler(KeyHandler.NOMENU);
allFuncs.hamDrawMenu = hamDrawMenu;
allFuncs.submitAll = submitAll;
allFuncs.cdtonum = cdtonum;
allFuncs.cdback = cdback;
allFuncs.cdhome = cdhome;
allFuncs.close = quitMenu;
allFuncs.toEditMode = toEditMode;
