function  fingerprint(filename, savepath, savename)

    try
        image1 =loadimage(filename);
    catch 

        quit force;
    end

% Enhancement by histogram Equalization
    try
        image1=histeq(uint8(image1));
    catch
        quit force;
    end


% fft

    try
        W=str2double('0.1');
        image1=fftenhance(image1,W);
    catch
        quit force;
    end

% Binarization
    try
        image1=adaptiveThres(double(image1),32);
    catch
        quit force;
    end
    

% Direction
    try 
        [o1Bound,o1Area]=direction(image1,16);
    catch
        quit force;
    end

% ROI
    try
        [o2,o1Bound,o1Area]=drawROI(image1,o1Bound,o1Area);
    catch
        quit force;
    end


% Thining
    try
        o1=im2double(bwmorph(o2,'thin',Inf));
    catch
        quit force;
    end


% Remove H breaks
    o1=im2double(bwmorph(o1,'clean'));
    o1=im2double(bwmorph(o1,'hbreak'));


% Remove Spike
    o1=im2double(bwmorph(o1,'spur'));


% Extract
    w =16;
    try
        [end_list1,branch_list1,ridgeMap1,edgeWidth]=mark_minutia(o1,o1Bound,o1Area,w);
    catch
        quit force;
    end

% Real Minutia
    try
        [pathMap1,real_end1,real_branch1]=remove_spurious_Minutia(o1,end_list1,branch_list1,o1Area,ridgeMap1,edgeWidth);
    catch
        quit force;
    end

% Save the minutae 
    cd(savepath);
    try
        save(savename,'real_end1','pathMap1','-ASCII');
    catch
        quit force;
    end

    quit force;
end
