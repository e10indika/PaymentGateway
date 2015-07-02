function image1=loadimage(filename)
% dialog for opening fingerprint files
%Honors Project 2001~2002
%wuzhili 99050056
%comp sci HKBU
%last update 19/April/2002

% [imagefile1 , pathname]= uigetfile('*.bmp;*.BMP;*.tif;*.TIF;*.jpg','Open An Fingerprint image'); 
% if imagefile1 ~= 0 
% cd(pathname);
image1=readimage(char(filename));
image1=255-double(image1);

end


