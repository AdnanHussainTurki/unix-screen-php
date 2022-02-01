exitcode=1

user=$1
passwd=$2
/usr/sbin/useradd $user -d /home/$user  -m  ;
userCreatedExitCode=$?
echo "User created: " $userCreatedExitCode

passwd ${user} << EOD
${passwd}
${passwd}
EOD
passwordUpdateExitCode=$?
echo "Password Updated: " $passwordUpdateExitCode


chmod 711 /home/$user
directoryPermissionsExitCode=$?
echo "Directory Permission Change: " $directoryPermissionsExitCode


if [ $userCreatedExitCode -eq 0 ] &&  [ $passwordUpdateExitCode -eq 0 ] && [  $directoryPermissionsExitCode -eq 0 ]; then
    echo "All done!"
    exitcode=0
else
    userdel -r $user
    exitcode=1
fi


echo "exitcode_by_script:$exitcode"