#!/usr/bin/env bash

# Your installation or use of this SugarCRM file is subject to the applicable
# terms available at
# http://support.sugarcrm.com/Resources/Master_Subscription_Agreements/.
# If you do not agree to all of the applicable terms or do not have the
# authority to bind the entity as an authorized representative, then do not
# install or use this SugarCRM file.
#
# Copyright (C) SugarCRM Inc. All rights reserved.

while :
do
    case "$1" in
        -f)
            IDM_FOLDER="$2"
            shift 2
            ;;
        *)
            break
            ;;
    esac
done

if [[ -z ${IDM_FOLDER} ]]
then
    printf "Please set up IdM folder for mapping in container: -f /var/www/IdentityProvider \n\n"
    exit
fi

# Retry to create network. Kubernetes can lag after previous ./undeploy.sh.
for i in {1..5};
do
  kubectl create namespace idm-ns && break
  sleep 30
done

kubectl --namespace idm-ns create -f ./selenium-service.yaml
kubectl --namespace idm-ns create -f ./selenium-deployment.yaml

cat idm-pod.yaml.template | sed -e "s~%%IDM_FOLDER%%~${IDM_FOLDER}~g" > idm-pod.yaml
kubectl --namespace idm-ns create -f ./idm-pod.yaml
rm idm-pod.yaml

kubectl --namespace idm-ns create -f ./ldap-service.yaml
kubectl --namespace idm-ns create -f ./ldap-deployment.yaml

kubectl --namespace idm-ns create -f ./saml-service.yaml
kubectl --namespace idm-ns create -f ./saml-deployment.yaml

kubectl --namespace idm-ns create -f ./mango/base-services.yaml
kubectl --namespace idm-ns create -f ./mango/base-deployment.yaml

kubectl --namespace idm-ns create configmap mango-config --from-file=./mango/config/

kubectl --namespace idm-ns create -f ./mango/saml-base-service.yaml
kubectl --namespace idm-ns create -f ./mango/saml-base-deployment.yaml

kubectl --namespace idm-ns create -f ./mango/saml-same-window-service.yaml
kubectl --namespace idm-ns create -f ./mango/saml-same-window-deployment.yaml

kubectl --namespace idm-ns create -f ./mango/saml-same-window-no-user-provision-service.yaml
kubectl --namespace idm-ns create -f ./mango/saml-same-window-no-user-provision-deployment.yaml