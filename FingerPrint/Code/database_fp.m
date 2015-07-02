function database_fp(user_id, accept)


conn = database('fp','root','','Vendor','MySQL','Server','localhost');

% curs = exec(conn,'select * from user_login_data');
% curs = fetch(curs);
% data = curs.Data;
% disp(data);
colnames = {'user_id','approval'};

data = {user_id accept};
disp(user_id);
tablename = 'user_finger_maching';

datainsert(conn,tablename,colnames,data);

end