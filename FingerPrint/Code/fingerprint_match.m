function fingerprint_match(user_id,finger1_path,finger2_path,cardnumber)

    currentfolder = pwd;
    try 
        finger1 = fingerTemplateRead(finger1_path,cardnumber);
    catch
        quit force;
    end

    cd(currentfolder);
    try
        finger2 = fingerTemplateRead(finger2_path,cardnumber);
    catch
        quit force;
    end

    cd(currentfolder);
    try 
        percent_match = match_end(finger1,finger2,10);
    catch
        quit force;
    end

    accept = 0;
    disp(accept);
    if(percent_match > 85)
        accept = 1;
        disp(accept);
    end
    disp(percent_match);

    try
        database_fp(user_id,accept);
    catch
        quit force;
    end

    quit force;

end
