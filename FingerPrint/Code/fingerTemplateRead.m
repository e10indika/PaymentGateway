function template=fingerTemplateRead(pathname, templatefile)
%dialog for opening fingerprint files
%Honors Project 2001~2002
%wuzhili 99050056
%comp sci HKBU
%last update 19/April/2002


if templatefile ~= 0 
cd(pathname);
disp(pathname);
disp(templatefile);
template=load(char(templatefile));
end;
