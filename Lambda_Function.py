import json
import boto3

ec2_resource = boto3.resource('ec2')
ec2_client = boto3.client('ec2')

def lambda_handler(event, context):
    filters = [
        {
            'Name': 'instance-state-name',
            'Values': ['*']
        }
    ]
    instances = ec2_resource.instances.filter(Filters=filters)
    
    instance_details = {}
    allowed_ports = []
    
    
    for instance in instances:
        security_group = ec2_client.describe_security_groups(GroupIds=[instance.security_groups[0]['GroupId']])
        for ports in security_group['SecurityGroups'][0]['IpPermissions']:
            if ports['ToPort'] > 0:
                for port in range(ports['FromPort'], ports['ToPort'] + 1):
                    if port not in allowed_ports:
                        allowed_ports.append(port)
        instance_details[instance.id] = allowed_ports
        instance_details_sms = ''
        for key, value in instance_details.items():
            instance_details_sms += f'{key} {value} \n'
        
    client = boto3.client(
        'sns', 
        aws_access_key_id='xxxxxx',
        aws_secret_access_key='xxxxxx',
        region_name='us-west-2'
    )
    client.publish(
        PhoneNumber='+1xxxxxxxxxx',
        Message=instance_details_sms
    )

    return {
        'statusCode': 200,
        'body': json.dumps(instance_details)
        
    }

